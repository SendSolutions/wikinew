<?php

namespace BookStack\Entities\Controllers;

use BookStack\Entities\Company;
use BookStack\Users\Models\User;
use Illuminate\Http\Request;
use BookStack\Http\Controller;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    /**
     * Estabelecer as permissões para acesso a este controlador.
     */
    protected function setupPermissions()
    {
        $this->middleware('auth');
        $this->middleware('can:manage-users');
    }

    /**
     * Lista as empresas.
     */
    public function index()
    {
        $companies = Company::orderBy('name')->paginate(20);
        return view('companies.index', compact('companies'));
    }

    /**
     * Exibe o formulário para criar uma nova empresa.
     */
    public function create()
    {
        $users = \BookStack\Users\Models\User::orderBy('name', 'asc')->get();
        return view('companies.create', compact('users'));
    }

    /**
     * Armazena uma nova empresa no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:companies,name|max:255',
            'description' => 'nullable',
        ]);

        Company::create($request->only(['name', 'description']));

        return redirect()->route('companies.index')
            ->with('success', 'Empresa criada com sucesso.');
    }

    /**
     * Exibe o formulário para editar uma empresa.
     */
    public function edit(int $id)
    {
        $this->checkPermission('users-manage');

        $company = Company::findOrFail($id);
        $users = User::orderBy('name', 'asc')->get();
        $companyUsers = $company->users->pluck('id')->toArray();

        $this->setPageTitle('Editar Empresa');

        return view('companies.edit', [
            'company'      => $company,
            'users'        => $users,
            'companyUsers' => $companyUsers,
        ]);
    }

    /**
     * Atualiza os dados de uma empresa.
     */
   /**
 * Atualiza os dados de uma empresa.
 */
public function update(Request $request, int $id)
{
    $this->preventAccessInDemoMode();
    $this->checkPermission('users-manage');

    $company = Company::findOrFail($id);

    $validated = $this->validate($request, [
        'name' => ['required', 'max:255', 'unique:companies,name,' . $id],
        'description' => ['nullable'],
    ]);

    // Processar o campo active
    $active = $request->has('active') ? true : false;
    
    // Atualização direta de todos os campos incluindo active
    $company->name = $validated['name'];
    $company->description = $validated['description'];
    $company->active = $active;
    $company->save();

    // Atualizar usuários vinculados
    if ($request->has('users')) {
        $company->users()->sync($request->input('users'));
    } else {
        $company->users()->detach();
    }

    return redirect('/settings/companies')
        ->with('success', 'Empresa atualizada com sucesso.');
}
    /**
     * Redireciona para a página de edição (caso a rota show seja chamada).
     */
    public function show(int $id)
    {
        $company = Company::findOrFail($id);
        return redirect()->route('companies.edit', ['company' => $company->id]);
    }

    /**
     * Exibe uma tela de confirmação para excluir uma empresa.
     */
    public function delete(int $id)
    {
        $company = Company::findOrFail($id);
        return view('companies.delete', compact('company'));
    }

    /**
     * Remove uma empresa do banco de dados.
     */
   /**
 * Desativa uma empresa.
 */
    /**
 * Desativa uma empresa.
 */
public function deactivate(int $id)
{
    $company = Company::findOrFail($id);
    
    // Adicione depuração para verificar se o método está sendo chamado
    Log::info("Desativando empresa: {$id} - {$company->name}");
    
    try {
        // Tente desativar a empresa
        $result = $company->update(['active' => false]);
        
        // Verificar se a atualização foi bem-sucedida
        Log::info("Resultado da atualização: " . ($result ? 'Sucesso' : 'Falha'));
        
        // Verificar o status após a atualização
        $company = Company::findOrFail($id);
        Log::info("Status após atualização: " . ($company->active ? 'Ativo' : 'Inativo'));
        
        return redirect('/settings/companies')
            ->with('success', 'Empresa desativada com sucesso.');
    } catch (\Exception $e) {
        Log::error("Erro ao desativar empresa: " . $e->getMessage());
        
        return redirect('/settings/companies')
            ->with('error', 'Erro ao desativar empresa: ' . $e->getMessage());
    }
}
public function activate(int $id)
{
    // Encontra a empresa pelo ID
    $company = Company::findOrFail($id);

    // Log para depuração
    \Illuminate\Support\Facades\Log::info("Ativando empresa: {$id} - {$company->name}");
    
    try {
        // Atualiza a empresa definindo o campo 'active' como true
        $result = $company->update(['active' => true]);
        
        // Log do resultado da atualização
        \Illuminate\Support\Facades\Log::info("Resultado da atualização: " . ($result ? 'Sucesso' : 'Falha'));
        
        // Recarrega a empresa para verificar o status
        $company = Company::findOrFail($id);
        \Illuminate\Support\Facades\Log::info("Status após atualização: " . ($company->active ? 'Ativo' : 'Inativo'));
        
        return redirect('/settings/companies')
            ->with('success', 'Empresa ativada com sucesso.');
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error("Erro ao ativar empresa: " . $e->getMessage());
        
        return redirect('/settings/companies')
            ->with('error', 'Erro ao ativar empresa: ' . $e->getMessage());
    }
}

}    

