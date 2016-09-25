@extends('layouts.main')
@section('content')

<style media="screen">

</style>


@if(count($book_data))
  <div class="container books-container">

      @foreach($book_data as $key => $value)
        @if($key % 2 == 0)
          <dir class="row">
        @endif
            <div class="col-sm-12 col-lg-6 books">
              <div class="col-sm-4">
                <a href="{{ action('SellController@show', ['id' => $value->id]) }}">
                  {!! Html::image('upload/' . $value->book_img, $value->book_name, ['class' => 'img-responsive', 'width' => 160]) !!}
                </a>
              </div>
              <div class="col-sm-8">
                <h4 class="books-name">
                  <a href="{{ action('SellController@show', ['id' => $value->id]) }}">{{ $value->book_name }}</a>
                </h4>
                <div class="author">
                  {{ $value->book_author }} <span style="color: #000;">著</span>
                </div>
                <div class="pirce" style="padding-top: 15px;">
                  售價 <span style="color: #da0;">${{ $value->book_price2 }}</span>
                </div>
              </div>
            </div>
        @if($key % 2 != 0)
          </dir>
        @endif

        @if(count($book_data) - $key == 1 && $key % 2 == 0)
          </dir>
        @endif
      @endforeach
      <hr />

  </div>

  <div class="text-center col-sm-12">
    <nav>
      <!-- 在網址後面連結page -->
      {{ $book_data->appends(Request::query())->render('vendor.pagination.bootstrap-4') }}

      {{ $book_data->appends(Request::query())->render('vendor.pagination.simple-bootstrap-4') }}
    </nav>
    <hr />
  </div>
@else
  <h2 class="text-danger" style="font-family: 'Microsoft JhengHei';">
    你還沒有刊登書籍唷~ <br /><br />
    <a role="button" href="{!! route('sell.create') !!} ">
      <i class="fa fa-cloud-upload"></i>&nbsp; 馬上刊登
    </a>
  </h2>
@endif

@endsection
