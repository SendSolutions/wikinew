@extends('layouts.simple')

@section('body')
@include('settings.parts.navbar', ['selected' => 'companies'])
<div class="container small">
    <div class="py-m">
        <h1 class="list-heading">Editar Empresa</h1>
    </div>

    <div class="card content-wrap auto-height">
        <form action="{{ url('/settings/companies/' . $company->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nome da Empresa --}}
            <div class="form-group">
                <label for="name">Nome da Empresa</label>
                <input type="text"
                       name="name"
                       id="name"
                       class="form-control"
                       placeholder="Nome da Empresa"
                       value="{{ old('name', $company->name) }}"
                       required>
                @error('name')
                    <div class="text-neg text-small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Descrição --}}
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description"
                          id="description"
                          rows="5"
                          class="form-control"
                          placeholder="Descrição da empresa">{{ old('description', $company->description) }}</textarea>
                @error('description')
                    <div class="text-neg text-small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Link para Registro de Usuários --}}
            <div class="form-group">
                <label class="setting-list-label mb-xs">Link para Registro de Usuários</label>
                <p class="small mb-xs">
                    Usuários podem se registrar diretamente para esta empresa utilizando o link abaixo:
                </p>
                <div class="flex-container-row items-center mb-m">
                    <input type="text"
                           id="registrationLink"
                           value="{{ url('/empresas/' . $company->slug) }}"
                           class="flex-grow form-control"
                           readonly>
                    <button id="copyButton" type="button" class="button outline ml-s">
                        Copiar Link
                    </button>
                </div>
            </div>

            {{-- Status (ativo/inativo) --}}
            <div class="form-group">
                <label>
                    <input type="checkbox" name="active" value="1"
                           {{ old('active', $company->active) ? 'checked' : '' }}>
                    Empresa Ativa
                </label>
                <p class="text-muted small">
                    Se desativada, a empresa não será considerada nas permissões de acesso.
                </p>
            </div>

            {{-- Painel de Filtros --}}
            <div class="form-group">
                <label class="setting-list-label mb-xs">Filtrar Usuários</label>
                <div class="flex-container-row items-center mb-m">
                    <select id="userFilter" class="form-control small mr-m">
                        <option value="all">Todos</option>
                        <option value="selected">Selecionados</option>
                        <option value="unselected">Não Selecionados</option>
                    </select>
                    <input type="text"
                           id="userSearch"
                           class="form-control small flex-grow"
                           placeholder="Buscar por nome...">
                </div>
            </div>

            {{-- Lista de Usuários Vinculados --}}
            <div class="form-group">
                <label>Usuários Vinculados</label>
                <div id="usersList" class="checkbox-group" style="max-height:300px; overflow-y:auto;">
                    @foreach($users as $user)
                        @php $checked = in_array($user->id, $companyUsers) @endphp
                        <div class="checkbox user-row">
                            <label>
                                <input type="checkbox"
                                       name="users[]"
                                       value="{{ $user->id }}"
                                       {{ $checked ? 'checked' : '' }}>
                                <span class="user-name">{{ $user->name }}</span>
                                <small class="text-muted">({{ $user->email }})</small>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Ações --}}
            <div class="grid half gap-xl">
                <div>
                    <a href="{{ url('/settings/companies') }}" class="button outline">Cancelar</a>
                </div>
                <div class="text-right">
                    <button type="submit" class="button">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Script externo com nonce para CSP --}}
<script src="{{ asset('js/company-edit.js') }}" nonce="{{ $cspNonce }}"></script>
@stop
