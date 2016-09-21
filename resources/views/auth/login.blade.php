@extends('layouts.main')
@section('content')

<div class="container my-container">

  <div class="row">
    @include('errors.list')
  </div>

  <div class="row">
    {!! Form::open(['action' => 'Auth\LoginController@login', 'method' => 'post']) !!}
      <div class="form-group">
        {!! Form::label('email', '學號') !!}
        <div class="input-group">
          {!! Form::text('email', null, ['class' => 'form-control', 'aria-describedby' => 'basic-addon1']) !!}
          <span class="input-group-addon" id="basic-addon1">@ntunhs.edu.tw</span>
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('password', '密碼') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
      </div>
      {!! Form::submit('登入', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    <hr />
  </div>

  <div class="row row-active">
    <a href="#" style="float: left;">忘記密碼？</a>
    <span style="float: right;">
      還不是北護二手書會員？
      <a href="register/sendMail">免費註冊</a>
    </span>
  </div>
</div>

@endsection
