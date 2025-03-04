@push('head')
    <script src="{{ versioned_asset('libs/tinymce/tinymce.min.js') }}" nonce="{{ $cspNonce }}"></script>
@endpush

{{ csrf_field() }}

@if(isset($book) && $book->slug === 'releases-notes')
    {{-- Campo oculto de título; o valor será preenchido automaticamente no controller --}}
    <input type="hidden" name="name" value="{{ isset($chapter) ? $chapter->name : '' }}">
@else
    <div class="form-group title-input">
        <label for="name">{{ trans('common.name') }}</label>
        @include('form.text', ['name' => 'name', 'autofocus' => true])
    </div>
@endif

<div class="form-group">
    {{-- Campo para Data da Atualização, exibido para releases-notes --}}
    @if(isset($book) && $book->slug === 'releases-notes')
        <label for="update_date">Data da Atualização</label>
        <input required type="date" class="form-control" id="update_date" name="update_date"
               value="{{ old('update_date', isset($chapter) && $chapter->update_date ? \Carbon\Carbon::parse($chapter->update_date)->format('Y-m-d') : '') }}">
    @endif
</div>

<div class="form-group description-input">
    <label for="description_html">{{ trans('common.description') }}</label>
    @include('form.description-html-input')
</div>

{{-- Outros campos do formulário... --}}
<div class="form-group collapsible" component="collapsible" id="logo-control">
    <button refs="collapsible@trigger" type="button" class="collapse-title text-link" aria-expanded="false">
        <label for="tags">{{ trans('entities.chapter_tags') }}</label>
    </button>
    <div refs="collapsible@content" class="collapse-content">
        @include('entities.tag-manager', ['entity' => $chapter ?? null])
    </div>
</div>

<div class="form-group collapsible" component="collapsible" id="template-control">
    <button refs="collapsible@trigger" type="button" class="collapse-title text-link" aria-expanded="false">
        <label for="template-manager">{{ trans('entities.default_template') }}</label>
    </button>
    <div refs="collapsible@content" class="collapse-content">
        @include('entities.template-selector', ['entity' => $chapter ?? null])
    </div>
</div>

<div class="form-group text-right">
    <button type="submit" class="button">{{ trans('entities.chapters_save') }}</button>
</div>

@include('entities.selector-popup')
@include('form.editor-translations')
