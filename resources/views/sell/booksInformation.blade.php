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
  .books .table .price2 {
    font-size: 26px; color: #f00; }
  .books .table .discount {
    padding-left: 8px;
    color: #e70; font-size: 24px;
  }
  .table-hover>tbody>tr:hover {
    background-color: #eaeaea; }

  .books-information {
    padding-left: 13%;
    padding-top: 15px;
  }
  .books-information .leader {
    padding-right: 13%; }

  .message .plzLogin {
    font-size: 16px; }
  .message .login {
    color: #59f; }
  .message .login:hover {
    color: #008; }
  .message .content {
    padding-bottom: 13px; }
  .message .content p {
    padding-top: 8px;
    font-size: 16px;
  }
  .message .content a {
    font-size: 16px;
    color: #888;
  }
  .message .content a:hover {
    color: #59f; }
  .message .reply-form {
    padding-top: 20px;
    display: none;
  }
  .message .reply-form.expanded {
    display: block;
  }
  .message .reply-form input {
    margin-top: 13px; }

  @media (max-width: 570px) {
    .books .table td,
    .books .table .price2,
    .books .table .discount {
      font-size: 17px;
      padding-left: 0;
    }
    .books .table .btn-info {
      width: 68px; }
  }
  @media (max-width: 767px) {
    .books-information {
      padding-left: 5%; }
    .books-information .leader {
      padding-right: 17%;   }
  }
  @media (max-width: 991px) {
    .books-information {
      padding-left: 3%; }

    .message div[class^="col-md-"] {
      padding-left: 0;
      padding-right: 0;
    }
    .message .content {
      padding-left: 10px;
      padding-right: 10px;
    }
  }
  @media (min-width: 992px) {
    .message .messageBtn-padding {
      padding-bottom: 50px; }
  }
</style>

<div class="container">

  <div class="row">
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
          <tr>
            <td>備註</td>
            <td>
              {{ $book_data->book_other }}
            </td>
          </tr>
        @endif

        @if(Auth::check() && (Auth::user()->id == $book_data->user_id))
          <tr>
            <td style="vertical-align: middle;">Action</td>
            <td>
              <a href="{{ route('sell.edit', ['id' => $book_data->id]) }}" class="btn btn-info"><i class="fa fa-edit"></i> 編輯</a>
              <button href="button" class="btn btn-danger delete-btn"><i class="fa fa-trash-o"></i> 刪除</button>
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
  $(function () {
    // 傳送 token
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    get_data();
  });

  $('.delete-btn').click(function () {
    $('#myModal').modal('show');
  });

  $(document).on('click', '.reply', function() {
    $(this).css('display', 'none');
    $(this).next('.reply-form').addClass('expanded');
  });
  $(document).on('click', '.cancel', function() {
    var replyForm = $(this).parent('.reply-form');
    replyForm.removeClass('expanded');
    replyForm.prev('.reply').css('display', 'block');
  });

  // message board ajax
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
  function get_data() {
    var book_data_id = '{{ $book_data->id }}';

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
    var book_data_id = '{{ $book_data->id }}',
        user_id = '<?= (Auth::check()) ? Auth::user()->id : ''; ?>',
        area = content.data('area'),
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

        get_data();
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
