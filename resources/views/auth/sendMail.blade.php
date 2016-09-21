@extends('layouts.main')
@section('content')

<style media="screen">
.my-container {
  padding-top: 70px;
}
.my-container .form-group label {
  padding-bottom: 20px;
}
.my-container .btn-primary {
  margin-top: 20px;
  width: 100px;
}
</style>

<div class="container my-container">
  @if(session('sendMessage'))
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success">
          {{ session('sendMessage') }}
        </div>
      </div>
    </div>
  @endif

  <div class="row">
    @include('errors.list')
  </div>

  <div class="row">
    {!! Form::open(['action' => 'Auth\MailController@sendMail', 'method' => 'post']) !!}
      <div class="form-group">
        {!! Form::label('email', '請輸入您的學號來進行Mail發送') !!}
        <div class="input-group">
          {!! Form::text('email', null, ['class' => 'form-control', 'aria-describedby' => 'basic-addon1']) !!}
          <span class="input-group-addon" id="basic-addon1">@ntunhs.edu.tw</span>
        </div>
      </div>
      {!! Form::submit('傳送驗證信', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    <hr />
  </div>

</div>

@endsection
