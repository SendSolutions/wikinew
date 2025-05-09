<?php

namespace BookStack\Users\Controllers;

use BookStack\Access\SocialDriverManager;
use BookStack\Access\UserInviteException;
use BookStack\Exceptions\ImageUploadException;
use BookStack\Exceptions\UserUpdateException;
use BookStack\Http\Controller;
use BookStack\Uploads\ImageRepo;
use BookStack\Users\Models\Role;
use BookStack\Users\Queries\UsersAllPaginatedAndSorted;
use BookStack\Users\UserRepo;
use BookStack\Util\SimpleListOptions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct(
        protected UserRepo $userRepo,
        protected ImageRepo $imageRepo
    ) {
    }

    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $this->checkPermission('users-manage');

        $listOptions = SimpleListOptions::fromRequest($request, 'users')->withSortOptions([
            'name' => trans('common.sort_name'),
            'email' => trans('auth.email'),
            'created_at' => trans('common.sort_created_at'),
            'updated_at' => trans('common.sort_updated_at'),
            'last_activity_at' => trans('settings.users_latest_activity'),
        ]);

        $users = (new UsersAllPaginatedAndSorted())->run(20, $listOptions);

        $this->setPageTitle(trans('settings.users'));
        $users->appends($listOptions->getPaginationAppends());

        return view('users.index', [
            'users'       => $users,
            'listOptions' => $listOptions,
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $this->checkPermission('users-manage');
        $authMethod = config('auth.method');
        $roles = Role::query()->orderBy('display_name', 'asc')->get();
        $this->setPageTitle(trans('settings.users_add_new'));

        return view('users.create', [
            'authMethod' => $authMethod,
            'roles'      => $roles
        ]);
    }

    /**
     * Store a new user in storage.
     *
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->checkPermission('users-manage');

        $authMethod = config('auth.method');
        $sendInvite = ($request->get('send_invite', 'false') === 'true');
        $externalAuth = in_array($authMethod, ['ldap', 'saml2', 'oidc']);
        $passwordRequired = ($authMethod === 'standard' && !$sendInvite);

        $validationRules = [
            'name'             => ['required', 'max:100'],
            'email'            => ['required', 'email', 'unique:users,email'],
            'language'         => ['string', 'max:15', 'alpha_dash'],
            'roles'            => ['array'],
            'roles.*'          => ['integer'],
            'password'         => $passwordRequired ? ['required', Password::default()] : null,
            'password-confirm' => $passwordRequired ? ['required', 'same:password'] : null,
            'external_auth_id' => $externalAuth ? ['required'] : null,
        ];

        $validated = $this->validate($request, array_filter($validationRules));
        
        try {
            // Cria o usuário e sincroniza as empresas dentro de uma transação
            $user = DB::transaction(function () use ($validated, $sendInvite, $request) {
                $user = $this->userRepo->create($validated, $sendInvite);
                if ($request->has('companies')) {
                    $user->companies()->sync($request->input('companies'));
                } else {
                    $user->companies()->detach();
                }
                return $user;
            });
        } catch (UserInviteException $e) {
            Log::error("Failed to send user invite with error: {$e->getMessage()}");
            $this->showErrorNotification(trans('errors.users_could_not_send_invite'));
            return redirect('/settings/users/create')->withInput();
        }

        return redirect('/settings/users');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(int $id, SocialDriverManager $socialDriverManager)
    {
        $this->checkPermission('users-manage');

        $user = $this->userRepo->getById($id);
        $user->load(['apiTokens', 'mfaValues']);
        $authMethod = ($user->system_name) ? 'system' : config('auth.method');

        $activeSocialDrivers = $socialDriverManager->getActive();
        $mfaMethods = $user->mfaValues->groupBy('method');
        $this->setPageTitle(trans('settings.user_profile'));
        $roles = Role::query()->orderBy('display_name', 'asc')->get();

        // Carrega todas as empresas para enviar à view
        $companies = \BookStack\Entities\Company::all();

        return view('users.edit', [
            'user'                => $user,
            'activeSocialDrivers' => $activeSocialDrivers,
            'mfaMethods'          => $mfaMethods,
            'authMethod'          => $authMethod,
            'roles'               => $roles,
            'companies'           => $companies, // Variável adicionada
        ]);
    }

    /**
     * Update the specified user in storage.
     *
     * @throws UserUpdateException
     * @throws ImageUploadException
     * @throws ValidationException
     */
    public function update(Request $request, int $id)
    {
        $this->preventAccessInDemoMode();
        $this->checkPermission('users-manage');

        $validated = $this->validate($request, [
            'name'             => ['min:1', 'max:100'],
            'email'            => ['min:2', 'email', 'unique:users,email,' . $id],
            'password'         => ['required_with:password_confirm', Password::default()],
            'password-confirm' => ['same:password', 'required_with:password'],
            'language'         => ['string', 'max:15', 'alpha_dash'],
            'roles'            => ['array'],
            'roles.*'          => ['integer'],
            'external_auth_id' => ['string'],
            'profile_image'    => array_merge(['nullable'], $this->getImageValidationRules()),
        ]);

        $user = $this->userRepo->getById($id);
        $this->userRepo->update($user, $validated, true);

        // Salva a imagem de perfil, se houver
        if ($request->hasFile('profile_image')) {
            $imageUpload = $request->file('profile_image');
            $this->imageRepo->destroyImage($user->avatar);
            $image = $this->imageRepo->saveNew($imageUpload, 'user', $user->id);
            $user->image_id = $image->id;
            $user->save();
        }

        // Remove a imagem de perfil se solicitado
        if ($request->has('profile_image_reset')) {
            $this->imageRepo->destroyImage($user->avatar);
            $user->image_id = 0;
            $user->save();
        }

        return redirect('/settings/users');
    }

    /**
     * Show the user delete page.
     */
    public function delete(int $id)
    {
        $this->checkPermission('users-manage');

        $user = $this->userRepo->getById($id);
        $this->setPageTitle(trans('settings.users_delete_named', ['userName' => $user->name]));

        return view('users.delete', ['user' => $user]);
    }

    /**
     * Remove the specified user from storage.
     *
     * @throws Exception
     */
    public function destroy(Request $request, int $id)
    {
        $this->preventAccessInDemoMode();
        $this->checkPermission('users-manage');

        $user = $this->userRepo->getById($id);
        $newOwnerId = intval($request->get('new_owner_id')) ?: null;

        $this->userRepo->destroy($user, $newOwnerId);

        return redirect('/settings/users');
    }

    
}
