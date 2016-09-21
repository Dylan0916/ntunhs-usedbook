@extends('layouts.main')
@section('content')

<?php
  $department = [
    '護理系所' => '護理系所',
    '資訊管理系所' => '資訊管理系所',
    '長期照護系所' => '長期照護系所',
    '運動保健系所' => '運動保健系所',
    '嬰幼兒保育系所' => '嬰幼兒保育系所',
    '健康事業管理系所' => '健康事業管理系所',
    '語言治療與聽力學系' => '語言治療與聽力學系',
    '休閒產業與健康促進系所' => '休閒產業與健康促進系所',
    '生死與健康心理諮商系所' => '生死與健康心理諮商系所'
  ];
?>

<div class="container my-container">
  <div class="row">
    @include('errors.list')
  </div>

  <div class="row">
    {!! Form::open(['action' => ['Auth\RegisterController@register', 'id' => $code], 'method' => 'post']) !!}
      <div class="form-group">
        {!! Form::label('email', '學號') !!}
        <div class="input-group">
          {!! Form::text('email', $student_id[0], ['class' => 'form-control', 'aria-describedby' => 'basic-addon1', 'disabled']) !!}
          <span class="input-group-addon" id="basic-addon1">@ntunhs.edu.tw</span>
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('password', '密碼') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('password_confirmation', '密碼確認') !!}
        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('name') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('department', '系別') !!}
        {!! Form::select('department', $department, null, ['class' => 'form-control']) !!}
      </div>
      {!! Form::submit('註冊', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    <hr />
  </div>

</div>

@endsection
