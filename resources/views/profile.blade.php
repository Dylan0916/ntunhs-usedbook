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
  .container .row { padding-left: 0; }

  .my-container .profile-img-sm {
    display: block; margin: auto;
    width: 170px; height: 170px;
  }
  .profile-change-img {
      padding: 4px 10px;
      position: relative;
      background: #a9CEFA;
      margin-top: 20px;
      font-size: 15px;
      border: 1px solid #ddd;
      border-radius: 4px;
      display: inline-block;
      text-decoration: none;
  }
  .profile-change-img input {
      position: absolute;
      font-size: 30px;
      right: 0;
      top: 0;
      opacity: 0;
      filter: alpha(opacity=0);
      cursor: pointer
  }
  .profile-change-img:hover { background: #98CFFF; }


  @media (max-width: 500px) {
    h2.profile-email {
      font-weight: bold;
      font-size: 17px;
    }
    .profile table { font-size: 17px; }
  }

</style>

<div class="container my-container">

  <div class="row">
    @include('errors.list')
  </div>

  <div class="row profile-img-sm">
    {!! Html::image('assets/img/profile/' . $profile->img, $profile->name, ['class' => 'img-responsive', 'width' => 170]) !!}
  </div>

  <div class="row">
    {!! Form::model($profile, ['action' => ['ProfileController@store', 'id' => $profile->id], 'files' => 'true']) !!}
      <div class="col-md-12 text-center">
          <a href="#" class="profile-change-img">
              <input type="file" name="img" id="change-img"><i class="fa fa-refresh"></i> <span id="file-name">更改圖片</span>
          </a>
          <h2 class="profile-email">
            {{ $profile->email }}
          </h2>
      </div>

      <div class="col-md-12 profile" style="margin-top: 10px;">
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

<div class="container books-container" style="margin-top: 30px;">

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

<script type="text/javascript">
  $('#change-img').change(function() {
    var split = $(this).val().split('\\'),
        file_name = split[(split.length) - 1];
    $('#file-name').html(file_name);
  });
</script>

@endsection
