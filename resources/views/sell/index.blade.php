@extends('layouts.main')
@section('content')

<style media="screen">
  .books-container .books span {
    font-size: 16px;
    color: #555;
  }
  .books-container .books h3 { color: #da0; }
</style>


@if(count($book_data))
  <div class="container books-container">

    @foreach($book_data as $key => $value)
      <?php $discount = round( (($value->book_price2 / $value->book_price) * 10), 2 ); ?>
      @if($key % 2 == 0)
        <div class="row">
      @endif
          <div class="col-sm-12 col-lg-6 books">
            <div class="col-sm-4">
              <a href="{{ action('SellController@show', ['id' => $value->id]) }}">
                {!! Html::image('upload/' . $value->book_img, $value->book_name, ['class' => 'img-responsive']) !!}
              </a>
            </div>
            <div class="col-sm-8">
              <h4 class="books-name">
                <a href="{{ action('SellController@show', ['id' => $value->id]) }}">{{ $value->book_name }}</a>
              </h4>
              <span style="text-decoration: line-through;">原價 ${{ $value->book_price }}</span>
              <span style="padding-left: 20px;"><b>{{ $discount }}折</b></span>
              <h3 style="">${{ $value->book_price2 }}</h3>
            </div>
          </div>
      @if($key % 2 != 0)
        </div>
      @endif

      @if(count($book_data) - $key == 1 && $key % 2 == 0)
        </div>
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
  <h2 class="text-danger" style="font-family: 'Microsoft JhengHei';">抱歉還沒有人在這裡新增書籍 :( </h2>
@endif

@endsection
