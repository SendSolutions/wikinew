@extends('layouts.simple')

@section('body')
@include('settings.parts.navbar', ['selected' => 'companies'])
<div class="container small">
    <div class="py-m">
        <h1 class="list-heading">Editar Empresa</h1>
    </div>

    <div class="card content-wrap auto-height">
        <form action="{{ url('/settings/companies/' . $company->id) }}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">

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
                @if($errors->has('name'))
                    <div class="text-neg text-small">{{ $errors->first('name') }}</div>
                @endif
            </div>

            {{-- Descrição --}}
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description"
                          id="description"
                          rows="5"
                          class="form-control"
                          placeholder="Descrição da empresa">{{ old('description', $company->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="text-neg text-small">{{ $errors->first('description') }}</div>
                @endif
            </div>

            {{-- Status (ativo/inativo) como checkbox simples --}}
            <div class="form-group">
                <label>
                    <input type="checkbox" name="active" value="1" {{ old('active', $company->active) ? 'checked' : '' }}>
                    Empresa Ativa
                </label>
                <p class="text-muted small">Se desativada, a empresa não será considerada nas permissões de acesso.</p>
            </div>

            {{-- Seleção de Usuários Vinculados como Checkboxes --}}
            <div class="form-group">
                <label>Usuários Vinculados</label>
                <div class="checkbox-group">
                    @foreach($users as $user)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="users[]" value="{{ $user->id }}"
                                       {{ in_array($user->id, $companyUsers) ? 'checked' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

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
@stop