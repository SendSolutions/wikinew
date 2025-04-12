<?php

namespace BookStack\Entities\Controllers;

use BookStack\Activity\Models\View;
use BookStack\Activity\Tools\CommentTree;
use BookStack\Activity\Tools\UserEntityWatchOptions;
use BookStack\Entities\Models\Book;
use BookStack\Entities\Models\Chapter;
use BookStack\Entities\Company; // <--- Adicionado para trabalhar com empresas
use BookStack\Entities\Queries\EntityQueries;
use BookStack\Entities\Queries\PageQueries;
use BookStack\Entities\Repos\PageRepo;
use BookStack\Entities\Tools\BookContents;
use BookStack\Entities\Tools\Cloner;
use BookStack\Entities\Tools\NextPreviousContentLocator;
use BookStack\Entities\Tools\PageContent;
use BookStack\Entities\Tools\PageEditActivity;
use BookStack\Entities\Tools\PageEditorData;
use BookStack\Exceptions\NotFoundException;
use BookStack\Exceptions\PermissionsException;
use BookStack\Http\Controller;
use BookStack\References\ReferenceFetcher;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Throwable;

class PageController extends Controller
{
    public function __construct(
        protected PageRepo $pageRepo,
        protected PageQueries $queries,
        protected EntityQueries $entityQueries,
        protected ReferenceFetcher $referenceFetcher
    ) {
    }

    /**
     * Show the form for creating a new page.
     *
     * @throws Throwable
     */
    public function create(string $bookSlug, ?string $chapterSlug = null)
    {
        if ($chapterSlug) {
            $parent = $this->entityQueries->chapters->findVisibleBySlugsOrFail($bookSlug, $chapterSlug);
        } else {
            $parent = $this->entityQueries->books->findVisibleBySlugOrFail($bookSlug);
        }

        $this->checkOwnablePermission('page-create', $parent);

        // Redirect to draft edit screen if signed in
        if ($this->isSignedIn()) {
            $draft = $this->pageRepo->getNewDraftPage($parent);
            return redirect($draft->getUrl());
        }

        // Otherwise show the edit view if they're a guest
        $this->setPageTitle(trans('entities.pages_new'));
        return view('pages.guest-create', ['parent' => $parent]);
    }

    /**
     * Create a new page as a guest user.
     *
     * @throws ValidationException
     */
    public function createAsGuest(Request $request, string $bookSlug, ?string $chapterSlug = null)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($chapterSlug) {
            $parent = $this->entityQueries->chapters->findVisibleBySlugsOrFail($bookSlug, $chapterSlug);
        } else {
            $parent = $this->entityQueries->books->findVisibleBySlugOrFail($bookSlug);
        }

        $this->checkOwnablePermission('page-create', $parent);

        $page = $this->pageRepo->getNewDraftPage($parent);
        $this->pageRepo->publishDraft($page, [
            'name' => $request->get('name'),
        ]);

        return redirect($page->getUrl('/edit'));
    }

    /**
     * Show form to continue editing a draft page.
     *
     * @throws NotFoundException
     */
    public function editDraft(Request $request, string $bookSlug, int $pageId)
    {
        $draft = $this->queries->findVisibleByIdOrFail($pageId);
        $this->checkOwnablePermission('page-create', $draft->getParent());

        $editorData = new PageEditorData($draft, $this->entityQueries, $request->query('editor', ''));
        $this->setPageTitle(trans('entities.pages_edit_draft'));

        // Busca apenas empresas ativas para exibição (pode ajustar conforme necessário)
        $companies = Company::where('active', true)->orderBy('name')->get();

        return view('pages.edit', array_merge($editorData->getViewData(), ['companies' => $companies]));
    }

    /**
     * Store a new page by changing a draft into a page.
     *
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function store(Request $request, string $bookSlug, int $pageId)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
        ]);

        $draftPage = $this->queries->findVisibleByIdOrFail($pageId);
        $this->checkOwnablePermission('page-create', $draftPage->getParent());

        $page = $this->pageRepo->publishDraft($draftPage, $request->all());

        // Sincroniza as empresas associadas à página (usando um input, por exemplo, 'company_permissions')
        $page->companies()->sync($request->input('company_permissions', []));

        return redirect($page->getUrl());
    }

    public function show(string $bookSlug, string $pageSlug)
    {
        try {
            $page = $this->queries->findVisibleBySlugsOrFail($bookSlug, $pageSlug);
        } catch (NotFoundException $e) {
            $revision = $this->entityQueries->revisions->findLatestVersionBySlugs($bookSlug, $pageSlug);
            $page = $revision->page ?? null;
    
            if (is_null($page)) {
                throw $e;
            }
    
            return redirect($page->getUrl());
        }
    
        // Verificação de acesso por empresa:
        // Se o método 'companies' existe e a página tem empresas associadas,
        // então o usuário precisa estar logado e vinculado a uma das empresas.
        if (method_exists($page, 'companies')) {
            $pageCompanies = $page->companies;
            if ($pageCompanies->isNotEmpty()) {
                // Se o usuário não estiver logado, bloqueia o acesso
                if (!Auth::check()) {
                    return redirect('/')->with('error', 'Você não tem permissão para acessar esta página.');
                }
                $user = Auth::user();
                // Se o usuário não tiver empresas vinculadas, bloqueia o acesso
                if ($user->companies->isEmpty()) {
                    return redirect('/')->with('error', 'Você não tem permissão para acessar esta página.');
                }
                // Verifica se há interseção entre as empresas do usuário e as da página
                $userCompanyIds = $user->companies->pluck('id')->toArray();
                $pageCompanyIds = $pageCompanies->pluck('id')->toArray();
                if (empty(array_intersect($userCompanyIds, $pageCompanyIds))) {
                    return redirect('/')->with('error', 'Você não tem permissão para acessar esta página.');
                }
            }
        }
    
        // Verificação padrão do sistema
        $this->checkOwnablePermission('page-view', $page);
    
        $pageContent = new PageContent($page);
        $page->html = $pageContent->render();
        $pageNav = $pageContent->getNavigation($page->html);
    
        $sidebarTree = (new BookContents($page->book))->getTree();
        $commentTree = new CommentTree($page);
        $nextPreviousLocator = new NextPreviousContentLocator($page, $sidebarTree);
    
        View::incrementFor($page);
        $this->setPageTitle($page->getShortName());
    
        return view('pages.show', [
            'page'            => $page,
            'book'            => $page->book,
            'current'         => $page,
            'sidebarTree'     => $sidebarTree,
            'commentTree'     => $commentTree,
            'pageNav'         => $pageNav,
            'watchOptions'    => new UserEntityWatchOptions(user(), $page),
            'next'            => $nextPreviousLocator->getNext(),
            'previous'        => $nextPreviousLocator->getPrevious(),
            'referenceCount'  => $this->referenceFetcher->getReferenceCountToEntity($page),
        ]);
    }
    
    
    /**
     * Get page from an ajax request.
     *
     * @throws NotFoundException
     */
    public function getPageAjax(int $pageId)
    {
        $page = $this->queries->findVisibleByIdOrFail($pageId);
        $page->setHidden(array_diff($page->getHidden(), ['html', 'markdown']));
        $page->makeHidden(['book']);

        return response()->json($page);
    }

    /**
     * Show the form for editing the specified page.
     *
     * @throws NotFoundException
     */
    public function edit(Request $request, string $bookSlug, string $pageSlug)
    {
        $page = $this->queries->findVisibleBySlugsOrFail($bookSlug, $pageSlug);
        $this->checkOwnablePermission('page-update', $page);

        $editorData = new PageEditorData($page, $this->entityQueries, $request->query('editor', ''));
        if ($editorData->getWarnings()) {
            $this->showWarningNotification(implode("\n", $editorData->getWarnings()));
        }

        $this->setPageTitle(trans('entities.pages_editing_named', ['pageName' => $page->getShortName()]));

        // Busca as empresas ativas (ou todas, se preferir) para exibição
        $companies = Company::where('active', true)->orderBy('name')->get();

        return view('pages.edit', array_merge($editorData->getViewData(), ['companies' => $companies]));
    }
    public function update(Request $request, string $bookSlug, string $pageSlug)
    {
        // Carrega a página atual
        $page = $this->queries->findVisibleBySlugsOrFail($bookSlug, $pageSlug);
        $this->checkOwnablePermission('page-update', $page);
        
        // APENAS verifica se o HTML mudou, ignorando todas as outras alterações
        $oldHtml = trim($page->html);
        $newHtml = trim($request->input('html', $page->html));
        $summary = trim($request->input('summary', ''));
        
        // Verifica se o HTML está significativamente diferente
        // Comparação simples, mas tolerante a pequenas alterações de formatação
        $htmlDifferent = (abs(strlen($oldHtml) - strlen($newHtml)) > 200);
        
        // Log para diagnóstico (opcional)
        \Illuminate\Support\Facades\Log::info('Verificação de HTML', [
            'html_different' => $htmlDifferent ? 'sim' : 'não',
            'old_length' => strlen($oldHtml),
            'new_length' => strlen($newHtml),
            'diff_length' => abs(strlen($oldHtml) - strlen($newHtml))
        ]);
        
        // Exige changelog APENAS se o HTML mudou significativamente
        if ($htmlDifferent && strlen($summary) < 5) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Você precisa informar o que está sendo alterado para salvar as alterações.');
        }
    
        // Valida os demais campos
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
        ]);
    
        // Atualiza a página com os dados enviados
        $this->pageRepo->update($page, $request->all());
    
        // Sincroniza as empresas associadas à página, se houver
        if (method_exists($page, 'companies')) {
            $page->companies()->sync($request->input('company_permissions', []));
        }
    
        return redirect($page->getUrl());
    }


    /**
     * Save a draft update as a revision.
     *
     * @throws NotFoundException
     */
    public function saveDraft(Request $request, int $pageId)
    {
        $page = $this->queries->findVisibleByIdOrFail($pageId);
        $this->checkOwnablePermission('page-update', $page);

        if (!$this->isSignedIn()) {
            return $this->jsonError(trans('errors.guests_cannot_save_drafts'), 500);
        }

        $draft = $this->pageRepo->updatePageDraft($page, $request->only(['name', 'html', 'markdown']));
        $warnings = (new PageEditActivity($page))->getWarningMessagesForDraft($draft);

        return response()->json([
            'status'    => 'success',
            'message'   => trans('entities.pages_edit_draft_save_at'),
            'warning'   => implode("\n", $warnings),
            'timestamp' => $draft->updated_at->timestamp,
        ]);
    }

    /**
     * Redirect from a special link url which uses the page id rather than the name.
     *
     * @throws NotFoundException
     */
    public function redirectFromLink(int $pageId)
    {
        $page = $this->queries->findVisibleByIdOrFail($pageId);
        return redirect($page->getUrl());
    }

    /**
     * Show the deletion page for the specified page.
     *
     * @throws NotFoundException
     */
    public function showDelete(string $bookSlug, string $pageSlug)
    {
        $page = $this->queries->findVisibleBySlugsOrFail($bookSlug, $pageSlug);
        $this->checkOwnablePermission('page-delete', $page);
        $this->setPageTitle(trans('entities.pages_delete_named', ['pageName' => $page->getShortName()]));
        $usedAsTemplate =
            $this->entityQueries->books->start()->where('default_template_id', '=', $page->id)->count() > 0 ||
            $this->entityQueries->chapters->start()->where('default_template_id', '=', $page->id)->count() > 0;

        return view('pages.delete', [
            'book'    => $page->book,
            'page'    => $page,
            'current' => $page,
            'usedAsTemplate' => $usedAsTemplate,
        ]);
    }

    /**
     * Show the deletion page for the specified page.
     *
     * @throws NotFoundException
     */
    public function showDeleteDraft(string $bookSlug, int $pageId)
    {
        $page = $this->queries->findVisibleByIdOrFail($pageId);
        $this->checkOwnablePermission('page-update', $page);
        $this->setPageTitle(trans('entities.pages_delete_draft_named', ['pageName' => $page->getShortName()]));
        $usedAsTemplate =
            $this->entityQueries->books->start()->where('default_template_id', '=', $page->id)->count() > 0 ||
            $this->entityQueries->chapters->start()->where('default_template_id', '=', $page->id)->count() > 0;

        return view('pages.delete', [
            'book'    => $page->book,
            'page'    => $page,
            'current' => $page,
            'usedAsTemplate' => $usedAsTemplate,
        ]);
    }

    /**
     * Show a listing of recently created pages.
     */
    public function showRecentlyUpdated()
    {
        $visibleBelongsScope = function (BelongsTo $query) {
            $query->scopes('visible');
        };

        $pages = $this->queries->visibleForList()
            ->addSelect('updated_by')
            ->with(['updatedBy', 'book' => $visibleBelongsScope, 'chapter' => $visibleBelongsScope])
            ->orderBy('updated_at', 'desc')
            ->paginate(20)
            ->setPath(url('/pages/recently-updated'));

        $this->setPageTitle(trans('entities.recently_updated_pages'));

        return view('common.detailed-listing-paginated', [
            'title'         => trans('entities.recently_updated_pages'),
            'entities'      => $pages,
            'showUpdatedBy' => true,
            'showPath'      => true,
        ]);
    }

    /**
     * Show the view to choose a new parent to move a page into.
     *
     * @throws NotFoundException
     */
    public function showMove(string $bookSlug, string $pageSlug)
    {
        $page = $this->queries->findVisibleBySlugsOrFail($bookSlug, $pageSlug);
        $this->checkOwnablePermission('page-update', $page);
        $this->checkOwnablePermission('page-delete', $page);

        return view('pages.move', [
            'book' => $page->book,
            'page' => $page,
        ]);
    }

    /**
     * Does the action of moving the location of a page.
     *
     * @throws NotFoundException
     * @throws Throwable
     */
    public function move(Request $request, string $bookSlug, string $pageSlug)
    {
        $page = $this->queries->findVisibleBySlugsOrFail($bookSlug, $pageSlug);
        $this->checkOwnablePermission('page-update', $page);
        $this->checkOwnablePermission('page-delete', $page);

        $entitySelection = $request->get('entity_selection', null);
        if ($entitySelection === null || $entitySelection === '') {
            return redirect($page->getUrl());
        }

        try {
            $this->pageRepo->move($page, $entitySelection);
        } catch (PermissionsException $exception) {
            $this->showPermissionError();
        } catch (Exception $exception) {
            $this->showErrorNotification(trans('errors.selected_book_chapter_not_found'));
            return redirect($page->getUrl('/move'));
        }

        return redirect($page->getUrl());
    }

    /**
     * Show the view to copy a page.
     *
     * @throws NotFoundException
     */
    public function showCopy(string $bookSlug, string $pageSlug)
    {
        $page = $this->queries->findVisibleBySlugsOrFail($bookSlug, $pageSlug);
        $this->checkOwnablePermission('page-view', $page);
        session()->flashInput(['name' => $page->name]);

        return view('pages.copy', [
            'book' => $page->book,
            'page' => $page,
        ]);
    }

    /**
     * Create a copy of a page within the requested target destination.
     *
     * @throws NotFoundException
     * @throws Throwable
     */
    public function copy(Request $request, Cloner $cloner, string $bookSlug, string $pageSlug)
    {
        $page = $this->queries->findVisibleBySlugsOrFail($bookSlug, $pageSlug);
        $this->checkOwnablePermission('page-view', $page);

        $entitySelection = $request->get('entity_selection') ?: null;
        $newParent = $entitySelection ? $this->entityQueries->findVisibleByStringIdentifier($entitySelection) : $page->getParent();

        if (!$newParent instanceof Book && !$newParent instanceof Chapter) {
            $this->showErrorNotification(trans('errors.selected_book_chapter_not_found'));
            return redirect($page->getUrl('/copy'));
        }

        $this->checkOwnablePermission('page-create', $newParent);

        $newName = $request->get('name') ?: $page->name;
        $pageCopy = $cloner->clonePage($page, $newParent, $newName);
        $this->showSuccessNotification(trans('entities.pages_copy_success'));

        return redirect($pageCopy->getUrl());
    }
}