<?php

namespace BookStack\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use BookStack\Entities\Models\Page;

class CheckCompanyAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Obter o usuário atual
        $user = $request->user();
        
        // Prosseguir se o usuário não estiver autenticado
        if ($user === null) {
            return $next($request);
        }
        
        // Administradores passam automaticamente
        if ($user->can('view-all')) {
            return $next($request);
        }
        
        // Obtém o slug da página da rota
        $pageSlug = $request->route('pageSlug');
        $bookSlug = $request->route('bookSlug');
        
        if (!$pageSlug || !$bookSlug) {
            return $next($request);
        }
        
        // Encontra a página
        $page = Page::query()
            ->whereHas('book', function($query) use ($bookSlug) {
                $query->where('slug', '=', $bookSlug);
            })
            ->where('slug', '=', $pageSlug)
            ->first();
            
        if (!$page) {
            return $next($request);
        }
        
        // Se a página não tem restrições de empresa, permita o acesso
        if ($page->companies()->count() === 0) {
            return $next($request);
        }
        
        // Verifique se o usuário pertence a pelo menos uma empresa que tem acesso à página
        // Ao verificar permissões
        $userCompanyIds = $user->companies()->where('active', true)->pluck('companies.id')->toArray();
        $pageCompanyIds = $page->companies()->pluck('companies.id')->toArray();
        
        if (count(array_intersect($userCompanyIds, $pageCompanyIds)) === 0) {
            // Redireciona para a página inicial do BookStack com mensagem de erro
            // As rotas comuns no BookStack são '/' ou '/dashboard'
            return redirect('/')->with('error', 'Você não tem permissão para acessar esta página.');
        }
        
        return $next($request);
    }
}