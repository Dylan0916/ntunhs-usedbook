@extends('layouts.main')
@section('content')

<div class="container my-container">
  <div class="row">
    @include('errors.list')
  </div>

  <div class="row">
    {!! Form::open(['action' => 'Auth\ResetPasswordController@reset', 'method' => 'post']) !!}
      {!! Form::hidden('token', $token) !!}
      {!! Form::hidden('email', $email) !!}
      <div class="form-group">
        {!! Form::label('email', '學號') !!}
        <div class="input-group">
          {!! Form::text('email', $email, ['class' => 'form-control', 'aria-describedby' => 'basic-addon1', 'disabled']) !!}
          <span class="input-group-addon" id="basic-addon1">@ntunhs.edu.tw</span>
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('password', '新密碼') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('password_confirmation', '新密碼確認') !!}
        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
      </div>
      {!! Form::submit('重設密碼', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    <hr />
  </div>

</div>

@endsection
