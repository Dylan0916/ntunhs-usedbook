<ul class="pager">
    <!-- Previous Page Link -->
    @if ($paginator->onFirstPage())
        <li class="page-item disabled"><span class="page-link">首頁</span></li>
    @else
        <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
          <i class="fa fa-long-arrow-left"> 上一頁</i>
        </a></li>
    @endif

    <!-- Next Page Link -->
    @if ($paginator->hasMorePages())
        <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
          下一頁 <i class="fa fa-long-arrow-right"></i>
        </a></li>
    @else
        <li class="page-item disabled"><span class="page-link">末頁</span></li>
    @endif
</ul>
