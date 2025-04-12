@extends('layouts.simple')

@section('body')

    <div class="container">

        <div class="my-s">
            @include('entities.breadcrumbs', ['crumbs' => [
                $page->book,
                $page->chapter,
                $page,
                $page->getUrl('/permissions') => [
                    'text' => trans('entities.pages_permissions'),
                    'icon' => 'lock',
                ]
            ]])
        </div>

        <main class="card content-wrap auto-height">
            @include('form.entity-permissions', ['model' => $page, 'title' => trans('entities.pages_permissions')])
        </main>
        <div class="form-group">
            <label for="companies">Empresas com acesso</label>
            <select name="companies[]" id="companies" class="form-control" multiple>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}"
                        @if(isset($page) && $page->companies->contains($company->id))
                            selected
                        @endif>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
    </div>


@stop
