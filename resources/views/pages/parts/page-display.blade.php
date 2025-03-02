<div dir="auto">

    <h4 class="break-text" id="bkmrk-page-title">{{$page->name}}</h4>

    <div style="clear:left;"></div>

    @if (isset($diff) && $diff)
        {!! $diff !!}
    @else
        {!! isset($page->renderedHTML) ? $page->renderedHTML : $page->html !!}
    @endif
</div>