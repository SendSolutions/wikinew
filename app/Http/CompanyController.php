<?php

namespace BookStack\Http\Controllers;

use BookStack\Entities\Company;
use BookStack\Users\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Usar a permissão apropriada do BookStack
        $this->middleware('can:manage-users');
    }

    public function index()
    {
        $companies = Company::orderBy('name')->paginate(20);
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:companies,name|max:255',
            'description' => 'nullable',
        ]);

        Company::create($request->all());

        return redirect()->route('companies.index')
            ->with('success', 'Empresa criada com sucesso.');
    }

    public function edit(Company $company)
    {
        $users = User::orderBy('name')->get();
        $companyUsers = $company->users->pluck('id')->toArray();
        
        return view('companies.edit', compact('company', 'users', 'companyUsers'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|max:255|unique:companies,name,' . $company->id,
            'description' => 'nullable',
        ]);

        $company->update($request->all());
        
        // Atualizar usuários vinculados
        if ($request->has('users')) {
            $company->users()->sync($request->users);
        } else {
            $company->users()->detach();
        }

        return redirect()->route('companies.index')
            ->with('success', 'Empresa atualizada com sucesso.');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', 'Empresa excluída com sucesso.');
    }
}