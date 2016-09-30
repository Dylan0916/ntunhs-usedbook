@extends('layouts.main')
@section('content')

<div class="container my-container">

  <div class="row">
    @include('errors.list')
  </div>

  <div class="row">
    <h4 class="text-danger"><i class="fa fa-warning"></i> 註: 拜託不要頻繁傳信 ><</h4>
    {!! Form::open(['action' => 'FeedbackController@sendMail', 'method' => 'post']) !!}
      <div class="form-group">
        {!! Form::label('name', '您的稱呼') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'aria-describedby' => 'basic-addon1']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('email', '您的聯絡信箱') !!}
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('content', '回櫃 / 意見') !!}
        {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 6]) !!}
      </div>
      {!! Form::submit('送出', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    <hr />
  </div>

</div>

@endsection
