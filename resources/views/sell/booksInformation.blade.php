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
    font-size: 26px; color: #f00;
  }
  .books .table .discount {
    padding-left: 8px;
    color: #e70; font-size: 24px;
  }
  .table-hover>tbody>tr:hover {
    background-color: #eaeaea;
  }
  .books-information {
    padding-left: 13%;
    padding-top: 15px;
  }
  .books-information .leader {
    padding-right: 13%;
  }

  @media (max-width: 570px) {
    .books .table td,
    .books .table .price2,
    .books .table .discount {
      font-size: 17px;
      padding-left: 0;
    }
    .books .table .btn-info {
      width: 68px;
    }
  }
  @media (max-width: 767px) {
    .books-information {
      padding-left: 5%;
    }
    .books-information .leader {
      padding-right: 17%;
    }
  }
  @media (max-width: 991px) {
    .books-information {
      padding-left: 3%;
    }
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
  </div>

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
  $('.delete-btn').click(function () {
    $('#myModal').modal('show');
  });
</script>

@endsection
