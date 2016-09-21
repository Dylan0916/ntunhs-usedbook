@extends('layouts.main')
@section('content')

<style media="screen">
  .text-danger {
    font-size: 15px;
  }
</style>

<div class="container my-container">

  <div class="row">
    @include('errors.list')
  </div>

  <div class="row">
    <h4 class="text-danger"><i class="fa fa-warning"></i> 註: 若封面圖片不變，則可不選。</h4>
    {!! Form::model($book_data, ['route' => ['sell.update', 'id' => $book_data->id], 'method' => 'put', 'files' => 'true']) !!}
      @include('sell.booksForm')
      {!! Form::submit('更新', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    <hr />
  </div>

</div>

@endsection
