@extends('layouts.main')
@section('content')

<?php
  $department = [
    '1' => '護理系所',
    '2' => '資訊管理系所',
    '3' => '長期照護系所',
    '4' => '運動保健系所',
    '5' => '嬰幼兒保育系所',
    '6' => '健康事業管理系所',
    '7' => '語言治療與聽力學系',
    '8' => '休閒產業與健康促進系所',
    '9' => '生死與健康心理諮商系所'
  ];

  $discount = round( (($book_data->book_price2 / $book_data->book_price) * 10), 2 );
  $created_at = explode(' ', $book_data->created_at);
?>

<style media="screen">

</style>

<div class="container bookInformation-container">

  <div class="row" style="padding-left: 3%;">
    <div class="col-md-12 books">
      <div class="col-md-4">
        {!! Html::image('upload/' . $book_data->book_img, $book_data->book_name, ['class' => 'img-responsive', 'width' => 250]) !!}
      </div>
      <div class="col-md-8">
        <h4 class="books-name">
          {{ $book_data->book_name }}
        </h4>
        <table class="table table-hover">
          <tr>
            <td>原價</td>
            <td>
              <span style="text-decoration: line-through;">${{ $book_data->book_price }}</span>
            </td>
          </tr>
          <tr>
            <td style="vertical-align: middle;">售價</td>
            <td>
              <span class="price2">${{ $book_data->book_price2 }}</span>
              <span class="discount">[{{ $discount }}折]</span>
            </td>
          </tr>
          <tr>
            <td>折舊狀態</td>
            <td>
              {{ $book_data->book_status }}
            </td>
          </tr>
          <tr>
            <td>適用系別</td>
            <td>
              {{ $department[$book_data->department_id] }}
            </td>
          </tr>
          <tr>
            <td>刊登日期</td>
            <td>
              {{ $created_at[0] }}
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div class="row books-information">
    <div class="col-md-12 books">
      <h3>詳細資訊</h3>
      <table class="table table-hover">
        <tr>
          <td class="leader">ISBN</td>
          <td>
            {{ $book_data->book_ISBN }}
          </td>
        </tr>
        <tr>
          <td>作者</td>
          <td>
            {{ $book_data->book_author }}
          </td>
        </tr>
        <tr>
          <td>出版社</td>
          <td>
            {{ $book_data->book_publish }}
          </td>
        </tr>
        @if($book_data->book_other)
          <tr class="otherNoBr">
            <td>備註</td>
            <td>
              {!! nl2br($book_data->book_other) !!}
            </td>
          </tr>
          <tr class="otherBr">
            <td colspan="2">備註：</td>
          </tr>
          <tr class="otherBr">
            <td colspan="2">
              {!! nl2br($book_data->book_other) !!}
            </td>
          </tr>
        @endif

        @if(Auth::check())
          <tr>
              <td style="vertical-align: middle;">Action</td>
              <td>
                @if (Auth::user()->id != $book_data->user_id)
                  <button type="button" class="btn btn-primary favorites"></button>
                @else
                  <a href="{{ route('sell.edit', ['id' => $book_data->id]) }}" class="btn btn-info"><i class="fa fa-edit"></i> 編輯</a>
                  <button href="button" class="btn btn-danger delete-btn"><i class="fa fa-trash-o"></i> 刪除</button>
                @endif
              </td>
            </tr>
          @endif
      </table>
    </div>

    <div class="col-md-12 message">
      <h3 style="border-bottom: 1px solid #aaa; padding-bottom: 15px;">留言給賣家</h3>

      <div class="row ajaxMessage"></div>

      @if(Auth::check())
        <div class="col-md-9">
          <textarea name="new-message-content" rows="4" class="form-control"></textarea>
        </div>
        <div class="col-md-3">
          <div class="messageBtn-padding"></div>
          <input type="button" value="送出" class="form-control btn btn-primary new-messageBtn">
        </div>
      @else
        <div class="plzLogin">登入後進行留言！ <a href="{{ url('login') }}" class="login">登入</a></div>
      @endif

      <div class="message-board">

      </div>

    </div>
  </div>

  <hr />
</div>

<!-- 固定右下角 -->
<div class="bookInformation-fixed"></div>

<!-- Modal (浮窗) -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete</h4>
      </div>
      <div class="modal-body" style="font-size: 17px;">
        確定要刪除 {{ $book_data->book_name or '' }} ?
      </div>
      <div class="modal-footer">
        {!! Form::open(['route' => ['sell.destroy', 'id' => $book_data->id], 'method' => 'delete']) !!}
          <button type="submit" class="btn btn-danger" id="actionBtn">
            <i class="fa fa-trash-o"></i> 刪除
          </button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove"></i>
            Close
          </button>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var book_data_id = '{{ $book_data->id }}',
      user_id = '<?= (Auth::check()) ? Auth::user()->id : ''; ?>';

  $(function () {
    // 傳送 token
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    get_favoritesBtn();
    get_messageBoard_data();
  });

  $('.delete-btn').click(function () {
    $('#myModal').modal('show');
  });

  // add or remove favorites
  $('.btn.favorites').click(function () {
    $.ajax({
      url: '{{ action('SellController@add_favorites') }}',
      method: 'post',
      data: {
        'book_data_id': book_data_id,
        'user_id': user_id
      },
      success: function(response) {
        $('.bookInformation-fixed').css('display', 'block');
        if (response == 'remove') {
          $('.books-information .favorites').html('<i class="fa fa-heart-o"></i> 加入收藏');
          $('.bookInformation-fixed').html('已成功移除收藏 !');
        } else {
          $('.books-information .favorites').html('<i class="fa fa-heart"></i> 移除收藏');
          $('.bookInformation-fixed').html('已成功加入收藏 !');
        }
        $('.bookInformation-fixed').delay(3000).fadeOut(1000);

        get_favoritesBtn();
      },
    });
  });

  // show favorites btn
  function get_favoritesBtn() {
    $.ajax({
      url: '{{ action('SellController@show_favoritesBtn') }}',
      method: 'post',
      data: {
        'book_data_id': book_data_id,
        'user_id': user_id
      },
      success: function(response) {
        var favoritesBtn = $('.books-information .favorites');
        if (response == 'N') favoritesBtn.html('<i class="fa fa-heart-o"></i> 加入收藏');
        else favoritesBtn.html('<i class="fa fa-heart"></i> 移除收藏');

        favoritesBtn.css('display', 'inline');
      },
    });
  }

  // 回覆鍵 與 回覆表單切換
  $(document).on('click', '.reply', function() {
    $(this).css('display', 'none');
    $(this).next('.reply-form').addClass('expanded');
  });
  $(document).on('click', '.cancel', function() {
    var replyForm = $(this).parent('.reply-form');
    replyForm.removeClass('expanded');
    replyForm.prev('.reply').css('display', 'block');
  });

  // message board btn ajax
  $('.new-messageBtn').click(function () {
    var content = $('[name="new-message-content"]');
    messageBoard_ajax(content, null);
  });
  $(document).on('click', '.reply-form .message', function () {
    var content = $(this).prev('[name="content"]'),
        replyForm = $(this).parent('.reply-form');
    messageBoard_ajax(content, replyForm);
  });

  // 取得留言資料
  function get_messageBoard_data() {
    $.ajax({
      url: '{{ action("SellController@show_messageBoard") }}',
      method: 'post',
      data: {
        'book_data_id': book_data_id
      },
      success: function(response) {
        $('.message-board').html(response);
      },
    });
  }

  function messageBoard_ajax(content, replyForm) {
    var area = content.data('area'),
        ajaxMessage = $('.ajaxMessage');

    // 新增留言
    $.ajax({
      url: '{{ action('SellController@create_messageBoard') }}',
      method: 'post',
      data: {
        'book_data_id': book_data_id,
        'user_id': user_id,
        'content': content.val(),
        'area': area
      },
      success: function(response) {
        // remove error message
        ajaxMessage.removeClass('alert alert-danger');

        // add success message
        ajaxMessage.addClass('alert alert-success').html('<p class="text-success" style="font-size: 16px;"><i class="glyphicon glyphicon-exclamation-sign"></i> ' + response + '</p>');

        // remove message
        content.val('');

        // 將留言框隱藏
        if (replyForm) {
          replyForm.removeClass('expanded');
          replyForm.prev('.reply').css('display', 'block');
        }

        get_messageBoard_data();
      },
      error: function(xhr) {
        var errors  = xhr.responseJSON;
        var error   = errors.content[0];

        if (error) {
          // remove success message
          ajaxMessage.removeClass('alert alert-success');

          // add error message
          ajaxMessage.addClass('alert alert-danger').html('<p class="text-danger" style="font-size: 16px;"><i class="glyphicon glyphicon-exclamation-sign"></i> ' + error + '</p>');
        }
      }
    });
  }
</script>

@endsection
