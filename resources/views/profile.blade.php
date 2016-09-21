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

<style media="screen">
   .my-container img {
    display: block;
    margin: auto;
    border: 1.5px solid #f5f5f5;
    transition: border-color 500ms, padding 300ms;
    -webkit-transition: border-color 500ms, padding 300ms;
  }
   .my-container img:hover {
    border-color: #A42D00;
    padding: 5px;
  }

  .container .row {
    padding-left: 0; }
  .container .author {
    color: #088; font-size: 15px; }

  @media (max-width: 500px) {
    h2.text-center {
      font-weight: bold;
      font-size: 17px;
    }
    .profile table {
      font-size: 17px; }
  }
  @media (max-width: 340px) {
    .container .author {
      font-size: 13px; }
  }
</style>

<div class="container my-container">

  <div class="row">
    @include('errors.list')
  </div>

  <div class="row">
    {!! Html::image('assets/img/profile/hello.png', 'Hello', ['class' => 'img-responsive', 'width' => 350]) !!}
  </div>

  <div class="row">
    <div class="col-md-12">
        <h2 class="profile-email text-center">
          {{ $profile->email }}
        </h2>
    </div>
    {!! Form::model($profile, ['action' => ['ProfileController@store', 'id' => $profile->id]]) !!}
      <div class="col-md-12 profile">
        <table class="table table-hover">
          <tr>
            <td>Name</td>
            <td>
              {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </td>
          </tr>
          <tr>
            <td>系別</td>
            <td>
              {!! Form::select('department', $department, null, ['class' => 'form-control']) !!}
            </td>
          </tr>
        </table>
        <button type="submit" class="btn btn-success">
          <i class="fa fa-check-square-o "></i>
          送出
        </button>
      </div>
    {!! Form::close() !!}
  </div>
</div>

<div class="container books" style="padding-top: 30px; margin-top: 30px;">

  <h3>為您推薦的書籍</h3>
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

@endsection
