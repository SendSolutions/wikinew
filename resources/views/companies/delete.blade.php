@extends('layouts.simple')

@section('body')
<div class="container small">
    <div class="py-m">
        <h1 class="list-heading">Desativar Empresa: {{ $company->name }}</h1>
    </div>

    <div class="card content-wrap auto-height">
        <p>Tem certeza que deseja desativar esta empresa?</p>
        <p>Esta ação manterá os dados históricos, mas a empresa não estará mais disponível para uso.</p>

        <div class="grid half gap-xl">
            <div>
                <a href="{{ url('/settings/companies') }}" class="button outline">{{ trans('common.cancel') }}</a>
            </div>
            <div class="text-right">
                <form action="{{ url('/settings/companies/' . $company->id . '/deactivate') }}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PUT">
                    <button type="submit" class="button warning">Confirmar Desativação</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop