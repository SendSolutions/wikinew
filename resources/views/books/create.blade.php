@extends('layouts.simple')

@section('body')
    <div class="container small">
        <div class="my-s">
            @if (isset($bookshelf))
                @include('entities.breadcrumbs', ['crumbs' => [
                    $bookshelf,
                    $bookshelf->getUrl('/create-book') => [
                        'text' => trans('entities.books_create'),
                        'icon' => 'add'
                    ]
                ]])
            @else
                @include('entities.breadcrumbs', ['crumbs' => [
                    '/books' => [
                        'text' => trans('entities.books'),
                        'icon' => 'book'
                    ],
                    '/create-book' => [
                        'text' => trans('entities.books_create'),
                        'icon' => 'add'
                    ]
                ]])
            @endif
        </div>

        <main class="content-wrap card">
            <h1 class="list-heading">{{ trans('entities.books_create') }}</h1>
            <form action="{{ $bookshelf?->getUrl('/create-book') ?? url('/books') }}" method="POST" enctype="multipart/form-data">
                @include('books.parts.form', [
                    'returnLocation' => $bookshelf?->getUrl() ?? url('/books')
                ])
            </form>
        </main>
        @if(isset($book) && $book->slug === 'releases-notes')
        <div class="form-group">
            <label for="update_date">Data da Atualização</label>
            <!-- Utilizando input do tipo date (formato Y-m-d) -->
            <input type="date" class="form-control" id="update_date" name="update_date" value="{{ old('update_date') }}">
        </div>
        @endif

    </div>

@stop