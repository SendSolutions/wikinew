@extends('layouts.simple')

@section('body')
@include('settings.parts.navbar', ['selected' => 'companies'])
<div class="container small">
    <div class="py-m">
        <h1 class="list-heading">Adicionar Nova Empresa</h1>
    </div>

    <div class="card content-wrap">
        <form action="{{ url('/settings/companies') }}" method="POST">
            {!! csrf_field() !!}
            
            <!-- Nome da Empresa -->
            <div class="form-group">
                <label for="name">Nome da Empresa</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Nome da Empresa" value="{{ old('name') }}" required>
                @if($errors->has('name'))
                    <div class="text-neg text-small">{{ $errors->first('name') }}</div>
                @endif
            </div>
            
            <!-- Descrição -->
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descrição da empresa">{{ old('description') }}</textarea>
                @if($errors->has('description'))
                    <div class="text-neg text-small">{{ $errors->first('description') }}</div>
                @endif
            </div>

            <!-- Status (ativo/inativo) como checkbox simples -->
            <div class="form-group">
                <label>
                    <input type="checkbox" name="active" value="1" {{ old('active', '1') == '1' ? 'checked' : '' }}>
                    Empresa Ativa
                </label>
                <p class="text-muted small">Se desativada, a empresa não será considerada nas permissões de acesso.</p>
            </div>
           
            <!-- Botões de Ação -->
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