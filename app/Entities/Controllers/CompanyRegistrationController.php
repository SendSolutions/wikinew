<?php

namespace BookStack\Entities\Controllers;

use BookStack\Entities\Company;
use BookStack\Http\Controller;
use BookStack\Users\Models\Role;
use BookStack\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class CompanyRegistrationController extends Controller
{
    /**
     * Constructor para definir middlewares.
     */
    public function __construct()
    {
        // Garante que apenas usuários não autenticados possam acessar os métodos de registro.
        $this->middleware('guest')->only(['showRegistrationForm', 'register']);
    }

    /**
     * Exibe o formulário de registro para um usuário vinculado a uma empresa específica.
     */
    public function showRegistrationForm($slug)
    {
        if (Auth::check()) {
            return redirect('/')->with('info', 'Você já está autenticado no sistema.');
        }

        // Busca a empresa pelo slug e que esteja ativa.
        $company = Company::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        if (!$company->isActive()) {
            return redirect('/')->with('error', 'Esta empresa não está disponível para novos registros.');
        }

        return view('companies.register', [
            'company' => $company
        ]);
    }

    /**
     * Processa o registro de um usuário vinculado a uma empresa específica.
     */
    public function register(Request $request, $slug)
    {
        if (Auth::check()) {
            return redirect('/')->with('info', 'Você já está autenticado no sistema.');
        }

        // Busca a empresa pelo slug e que esteja ativa.
        $company = Company::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        if (!$company->isActive()) {
            return redirect('/')->with('error', 'Esta empresa não está disponível para novos registros.');
        }

        // Validação dos dados do formulário.
        // A regra 'unique:users,email' já garante que, se o e-mail estiver cadastrado, a validação falhará e retornará o erro.
        $this->validate($request, [
            'name'     => ['required', 'string', 'min:2', 'max:100'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required'      => 'O nome é obrigatório.',
            'name.min'           => 'O nome deve ter pelo menos 2 caracteres.',
            'email.required'     => 'O e-mail é obrigatório.',
            'email.email'        => 'Informe um e-mail válido.',
            'email.unique'       => 'Este e-mail já está sendo utilizado.',
            'password.required'  => 'A senha é obrigatória.',
            'password.min'       => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
        ]);

        // Busca o papel (role) "viewer" pelo ID fixo (ID 3).
        $viewerRole = Role::find(3);

        if (!$viewerRole) {
            Log::error('Papel viewer (ID 3) não encontrado ao registrar usuário via empresa.');
            return redirect()->back()->with('error', 'Não foi possível completar o registro. Entre em contato com o suporte.');
        }

        try {
            // Cria o usuário e vincula-o à empresa dentro de uma transação.
            DB::transaction(function () use ($request, $company, $viewerRole) {
                // Cria o usuário.
                $user = new User();
                $user->name  = $request->input('name');
                $user->email = $request->input('email');

                // Geração de slug para o usuário baseado no nome.
                $slugUser = Str::slug($user->name);
                $originalSlug = $slugUser;
                $counter = 1;
                while (User::where('slug', $slugUser)->exists()) {
                    $slugUser = $originalSlug . '-' . $counter++;
                }
                $user->slug = $slugUser;

                $user->password = Hash::make($request->input('password'));
                $user->email_confirmed = true; // Confirma o e-mail automaticamente.
                $user->save();

                // Vincula o usuário à empresa.
                $user->companies()->attach($company->id);

                // Atribui o papel de "viewer" ao usuário.
                $user->roles()->attach($viewerRole->id);
            });

            // Redireciona o usuário para a página de login com a mensagem de sucesso.
            return redirect('/login')->with('success', 'Registro concluído com sucesso! Por favor, faça login.');
            
        } catch (\Exception $e) {
            Log::error('Erro ao registrar usuário via empresa: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro durante o registro. Por favor, tente novamente.');
        }
    }
}
