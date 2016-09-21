@extends('layouts.main')
@section('content')

<div class="container my-container">

  <div class="row">
    @include('errors.list')
  </div>

  <div class="row">
    {!! Form::open(['route' => 'sell.store', 'method' => 'post', 'files' => 'true']) !!}
      @include('sell.booksForm')
      {!! Form::submit('上傳', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    <hr />
  </div>

</div>

@endsection
