<nav id="book-tree"
     class="book-tree mb-xl"
     aria-label="{{ trans('entities.books_navigation') }}">

    <h5>{{ trans('entities.books_navigation') }}</h5>

    <ul class="sidebar-page-list mt-xs menu entity-list">
        @foreach($sidebarTree as $bookChild)
            <li class="list-item-{{ $bookChild->getType() }} {{ $bookChild->getType() }} {{ $bookChild->isA('page') && $bookChild->draft ? 'draft' : '' }}">
                @include('entities.list-item-basic', ['entity' => $bookChild, 'classes' => $current->matches($bookChild)? 'selected' : ''])

                @if($bookChild->isA('chapter') && count($bookChild->visible_pages) > 0)
                    <div class="entity-list-item no-hover">
                        <span role="presentation" class="icon text-chapter"></span>
                        <div class="content">
                            @include('chapters.parts.child-menu', [
                                'chapter' => $bookChild,
                                'current' => $current,
                                'isOpen'  => $bookChild->matchesOrContains($current)
                            ])
                        </div>
                    </div>

                @endif

            </li>
        @endforeach
        @if (userCan('view', $book))
            <li class="list-item-book book">
                @include('entities.list-item-basic', ['entity' => $book, 'classes' => ($current->matches($book)? 'selected' : '')])
            </li>
        @endif

        
    </ul>
</nav>