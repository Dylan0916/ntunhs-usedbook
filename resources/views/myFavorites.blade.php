@extends('layouts.main')
@section('content')

<style media="screen">
  .container .row {
    padding-left: 0;
    margin: 0 -15px;
  }
  .container .author {
    color: #088; font-size: 15px; }
  .text-danger {
    padding-left: 50px; }

  @media (max-width: 768px) {
    .text-danger {
      padding-left: 0; }
  }
  @media (max-width: 340px) {
    .container .author {
      font-size: 13px; }
    .container .pirce {
      font-size: 17px; }
  }
</style>



@if(count($book_data))
  <div class="container">

      @foreach($book_data as $key => $value)
        @if($key % 2 == 0)
          <dir class="row">
        @endif
            <div class="col-sm-12 col-lg-6 books">
              <div class="col-sm-4">
                <a href="{{ action('SellController@show', ['id' => $value['book_data']->id]) }}">
                  {!! Html::image('upload/' . $value['book_data']->book_img, $value['book_data']->book_name, ['class' => 'img-responsive', 'width' => 160]) !!}
                </a>
              </div>
              <div class="col-sm-8">
                <h4 class="books-name">
                  <a href="{{ action('SellController@show', ['id' => $value['book_data']->id]) }}">{{ $value['book_data']->book_name }}</a>
                </h4>
                <div class="author">
                  {{ $value['book_data']->book_author }} <span style="color: #000;">著</span>
                </div>
                <div class="pirce" style="padding-top: 15px;">
                  售價 <span style="color: #da0;">${{ $value['book_data']->book_price2 }}</span>
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
    你還沒有收藏書籍唷~
  </h2>
@endif

@endsection
