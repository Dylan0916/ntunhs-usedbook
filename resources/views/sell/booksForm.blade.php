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
?>

<div class="form-group">
  {!! Form::label('book_ISBN', 'ISBN') !!}
  {!! Form::text('book_ISBN', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::label('book_name', '書名') !!}
  {!! Form::text('book_name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::label('book_author', '作者') !!}
  {!! Form::text('book_author', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::label('book_publish', '出版商') !!}
  {!! Form::text('book_publish', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::label('book_price', '原價') !!}
  {!! Form::number('book_price', null, ['class' => 'form-control', 'placeholder' => 'NTD']) !!}
</div>

<div class="form-group">
  {!! Form::label('book_price2', '售價') !!}
  {!! Form::number('book_price2', null, ['class' => 'form-control', 'placeholder' => 'NTD']) !!}
</div>

<div class="form-group">
  {!! Form::label('book_status', '折舊狀態') !!}
  {!! Form::text('book_status', null, ['class' => 'form-control', 'placeholder' => '8成新']) !!}
</div>

<div class="form-group">
  {!! Form::label('department_id', '適用系所') !!}
  {!! Form::select('department_id', $department, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::label('book_img', '書籍封面') !!}
  {!! Form::file('book_img', ['class' => 'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::label('book_other', '備註') !!}
  {!! Form::textarea('book_other', null, ['class' => 'form-control', 'placeholder' => '其他說明或交代事項，沒有則可不填', 'rows' => 5]) !!}
</div>
