<div component="page-editor" class="page-editor page-editor-{{ $editor }} flex-fill flex"
     option:page-editor:drafts-enabled="{{ $draftsEnabled ? 'true' : 'false' }}"
     @if(config('services.drawio'))
        drawio-url="{{ is_string(config('services.drawio')) ? config('services.drawio') : 'https://embed.diagrams.net/?embed=1&proto=json&spin=1&configure=1' }}"
     @endif
     @if($model->name === trans('entities.pages_initial_name'))
        option:page-editor:has-default-title="true"
     @endif
     option:page-editor:editor-type="{{ $editor }}"
     option:page-editor:page-id="{{ $model->id ?? '0' }}"
     option:page-editor:page-new-draft="{{ $isDraft ? 'true' : 'false' }}"
     option:page-editor:draft-text="{{ ($isDraft || $isDraftRevision) ? trans('entities.pages_editing_draft') : trans('entities.pages_editing_page') }}"
     option:page-editor:autosave-fail-text="{{ trans('errors.page_draft_autosave_fail') }}"
     option:page-editor:editing-page-text="{{ trans('entities.pages_editing_page') }}"
     option:page-editor:draft-discarded-text="{{ trans('entities.pages_draft_discarded') }}"
     option:page-editor:draft-delete-text="{{ trans('entities.pages_draft_deleted') }}"
     option:page-editor:draft-delete-fail-text="{{ trans('errors.page_draft_delete_fail') }}"
     option:page-editor:set-changelog-text="{{ trans('entities.pages_edit_set_changelog') }}">

     
    {{-- Header Toolbar --}}
    @include('pages.parts.editor-toolbar', [
         'model'       => $model,
         'editor'      => $editor,
         'isDraft'     => $isDraft,
         'draftsEnabled' => $draftsEnabled
    ])

    <div class="flex flex-fill mx-s mb-s justify-center page-editor-page-area-wrap">
        <div class="page-editor-page-area flex-container-column flex flex-fill">
            {{-- Title input --}}
            <div class="title-input page-title clearfix">
                <div refs="page-editor@titleContainer" class="input">
                    @include('form.text', [
                        'name'        => 'name',
                        'model'       => $model,
                        'placeholder' => trans('entities.pages_title')
                    ])
                </div>
            </div>

            <div class="flex-fill flex">
                {{-- Editors --}}
                <div class="edit-area flex-fill flex">
                    <input type="hidden" name="editor" value="{{ $editor->value }}">

                    @if($editor === \BookStack\Entities\Tools\PageEditorType::WysiwygLexical)
                        @include('pages.parts.wysiwyg-editor', ['model' => $model])
                    @endif

                    {{-- WYSIWYG Editor (TinyMCE - Deprecated) --}}
                    @if($editor === \BookStack\Entities\Tools\PageEditorType::WysiwygTinymce)
                        @include('pages.parts.wysiwyg-editor-tinymce', ['model' => $model])
                    @endif

                    {{-- Markdown Editor --}}
                    @if($editor === \BookStack\Entities\Tools\PageEditorType::Markdown)
                        @include('pages.parts.markdown-editor', ['model' => $model])
                    @endif
                </div>
            </div>
        </div>

        {{-- Lateral: Editor Toolbox (único) --}}
        <div class="relative flex-fill">
            <div component="editor-toolbox" class="floating-toolbox">
                <div class="tabs flex-container-column justify-flex-start">
                    <div class="tabs-inner flex-container-column justify-center">
                        <button type="button" refs="editor-toolbox@toggle" title="{{ trans('entities.toggle_sidebar') }}" aria-expanded="false" class="toolbox-toggle">@icon('caret-left-circle')</button>
                        <button type="button" refs="editor-toolbox@tab-button" data-tab="tags" title="{{ trans('entities.page_tags') }}" class="active">@icon('tag')</button>
                        @if(userCan('attachment-create-all'))
                            <button type="button" refs="editor-toolbox@tab-button" data-tab="files" title="{{ trans('entities.attachments') }}">@icon('attach')</button>
                        @endif
                        <button type="button" refs="editor-toolbox@tab-button" data-tab="templates" title="{{ trans('entities.templates') }}">@icon('template')</button>
                        <button type="button" refs="editor-toolbox@tab-button" data-tab="companies" title="Empresas">@icon('users')</button>
                        @if($comments->enabled())
                            <button type="button" refs="editor-toolbox@tab-button" data-tab="comments" title="{{ trans('entities.comments') }}">@icon('comment')</button>
                        @endif
                    </div>
                </div>

                <div refs="editor-toolbox@tab-content" data-tab-content="tags" class="toolbox-tab-content">
                    <h4>{{ trans('entities.page_tags') }}</h4>
                    <div class="px-l">
                        @include('entities.tag-manager', ['entity' => $page])
                    </div>
                </div>

                @if(userCan('attachment-create-all'))
                    @include('attachments.manager', ['page' => $page])
                @endif

                <div refs="editor-toolbox@tab-content" data-tab-content="templates" class="toolbox-tab-content">
                    <h4>{{ trans('entities.templates') }}</h4>
                    <div class="px-l">
                        @include('pages.parts.template-manager', ['page' => $page, 'templates' => $templates])
                    </div>
                </div>

                {{-- Aba de Empresas (integrada na mesma toolbox) --}}
                <div refs="editor-toolbox@tab-content" data-tab-content="companies" class="toolbox-tab-content">
                    <h4>Permissões por Empresa</h4>
                    <div class="px-l">
                        <p class="small">Selecione as empresas que têm permissão para acessar esta página. Se nenhuma for selecionada, a página estará visível para todos.</p>
                        
                        @php
                            // Buscar apenas empresas ativas
                            $companiesList = \BookStack\Entities\Company::where('active', true)->orderBy('name')->get();
                            
                            // Definir a entidade atual corretamente
                            $currentEntity = isset($page) ? $page : $model;
                            
                            // Obter as empresas vinculadas à página atual (se existir)
                            $pageCompanies = [];
                            if ($currentEntity && method_exists($currentEntity, 'companies')) {
                                $pageCompanies = $currentEntity->companies->pluck('id')->toArray();
                            }
                        @endphp
                        
                        @if(count($companiesList) > 0)
                            <div class="form-group">
                                <div class="grid half">
                                    @foreach($companiesList as $company)
                                        <div class="setting-list-item">
                                            <label class="setting-list-item-label">
                                                <input type="checkbox" name="company_permissions[]" value="{{ $company->id }}" 
                                                    {{ in_array($company->id, old('company_permissions', $pageCompanies)) ? 'checked' : '' }}>
                                                <span>{{ $company->name }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="setting-list-item">
                                <p class="text-warn">Não há empresas ativas disponíveis.</p>
                                <p class="text-muted small">Para definir permissões específicas, primeiro ative ou <a href="{{ url('/settings/companies/create') }}" target="_blank">crie uma empresa</a>.</p>
                            </div>
                        @endif
                    </div>
                </div>
                @if($comments->enabled())
                    @include('pages.parts.toolbox-comments')
                @endif
            </div>
        </div>
    </div>a

    {{-- Mobile Save Button --}}
    <button type="submit"
            id="save-button-mobile"
            title="{{ trans('entities.pages_save') }}"
            class="text-link text-button hide-over-m page-save-mobile-button">@icon('save')</button>

    {{-- Editor Change Dialog --}}
    @component('common.confirm-dialog', ['title' => trans('entities.pages_editor_switch_title'), 'ref' => 'page-editor@switch-dialog'])
        <p>
            {{ trans('entities.pages_editor_switch_are_you_sure') }}
            <br>
            {{ trans('entities.pages_editor_switch_consider_following') }}
        </p>
        <ul>
            <li>{{ trans('entities.pages_editor_switch_consideration_a') }}</li>
            <li>{{ trans('entities.pages_editor_switch_consideration_b') }}</li>
            <li>{{ trans('entities.pages_editor_switch_consideration_c') }}</li>
        </ul>
    @endcomponent

    {{-- Delete Draft Dialog --}}
    @component('common.confirm-dialog', ['title' => trans('entities.pages_edit_delete_draft'), 'ref' => 'page-editor@delete-draft-dialog'])
        <p>
            {{ trans('entities.pages_edit_delete_draft_confirm') }}
        </p>
    @endcomponent

    {{-- Saved Drawing --}}
    @component('common.confirm-dialog', ['title' => trans('entities.pages_drawing_unsaved'), 'id' => 'unsaved-drawing-dialog'])
        <p>
            {{ trans('entities.pages_drawing_unsaved_confirm') }}
        </p>
    @endcomponent

</div>