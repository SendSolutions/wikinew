@extends('layouts.simple')

@section('body')

<div class="container small">

    @include('settings.parts.navbar', ['selected' => 'companies'])
    <div class="py-m">
        <div class="flex-container-row wrap justify-space-between">
            <h1 class="list-heading">{{ trans('Empresas') }}</h1>
            <div>
                <a href="{{ url('/settings/companies/create') }}" class="button outline">{{ trans('Adicionar Nova Empresa') }}</a>
            </div>
        </div>
    </div>

    <div class="card content-wrap">
        @if(count($companies) > 0)
            <div class="flex-container-row justify-space-between mb-m">
                <div class="flex-container-row items-center gap-m">
                    <span class="text-muted">{{ $companies->total() }} {{ $companies->total() == 1 ? 'empresa' : 'empresas' }}</span>
                    <div class="flex-container-row items-center gap-s">
                        <span class="badge success px-s py-xxs mr-xs">Ativa</span>
                        <span class="text-small text-muted">{{ $companies->where('active', true)->count() }}</span>
                        <span class="badge danger px-s py-xxs ml-s mr-xs">Inativa</span>
                        <span class="text-small text-muted">{{ $companies->where('active', false)->count() }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" id="search-companies" class="input-base px-s py-xs" style="width: 220px;" placeholder="Buscar empresas...">
                </div>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th class="px-m">{{ trans('Nome') }}</th>
                        <th class="px-m">{{ trans('Descrição') }}</th>
                        <th class="px-m text-center">{{ trans('Status') }}</th>
                        <th class="px-m text-center">{{ trans('Usuários') }}</th>
                        <th class="px-m text-right">{{ trans('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $company)
                        <tr class="company-row">
                            <td class="px-m">
                                <span class="bold">{{ $company->name }}</span>
                            </td>
                            <td class="px-m text-muted">
                                {{ Str::limit($company->description, 80) }}
                            </td>
                            <td class="px-m text-center">
                                @if($company->active)
                                    <span class="badge success px-s py-xxs">Ativa</span>
                                @else
                                    <span class="badge danger px-s py-xxs">Inativa</span>
                                @endif
                            </td>
                            <td class="px-m text-center">
                                <span class="rounded bg-light px-m py-xxs">{{ $company->users->count() }}</span>
                            </td>
                            <td class="px-m text-right">
                                <div class="flex-container-row justify-end gap-xs">
                                    <a href="{{ url('/settings/companies/' . $company->id) }}" class="button outline small">
                                        {{ trans('common.edit') }}
                                    </a>
                                    <form action="{{ url('/settings/companies/' . $company->id . ($company->active ? '/deactivate' : '/activate')) }}" method="POST" class="inline">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="PUT">
                                        <button type="submit" class="button outline small {{ $company->active ? 'warning' : 'success' }}">
                                            {{ $company->active ? 'Desativar' : 'Ativar' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-m">
                {{ $companies->links() }}
            </div>
        @else
            <div class="flex-container-column items-center justify-center py-xl">
                <p class="text-muted mb-m">{{ trans('Nenhuma empresa cadastrada') }}</p>
                <a href="{{ url('/settings/companies/create') }}" class="button">{{ trans('Adicionar Nova Empresa') }}</a>
            </div>
        @endif
    </div>
</div>

<style>
.badge {
    display: inline-block;
    border-radius: 4px;
    font-size: 0.8em;
    font-weight: 500;
}
.badge.success {
    background-color: #4caf50;
    color: white;
}
.badge.danger {
    background-color: #f44336;
    color: white;
}
.bg-light {
    background-color: #f5f5f5;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
}
.inline {
    display: inline;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-companies');
    const companyRows = document.querySelectorAll('.company-row');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchText = this.value.toLowerCase();
            
            companyRows.forEach(row => {
                const name = row.querySelector('td:first-child').textContent.toLowerCase();
                const description = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                
                if (name.includes(searchText) || description.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>

@stop