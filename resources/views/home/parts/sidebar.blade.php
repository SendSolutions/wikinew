@if(count($draftPages) > 0)
    <div id="recent-drafts" class="mb-xl">
        <h5>{{ trans('entities.my_recent_drafts') }}</h5>
        @include('entities.list', ['entities' => $draftPages, 'style' => 'compact'])
    </div>
@endif

@if(count($favourites) > 0)
    <div id="top-favourites" class="mb-xl">
        <h5>{{ trans('entities.my_most_viewed_favourites') }}</h5>
        @include('entities.list', [
            'entities' => $favourites,
            'style' => 'compact',
        ])
        <a href="{{ url('/favourites')  }}" class="text-muted block py-xs">{{ trans('common.view_all') }}</a>
    </div>
@endif