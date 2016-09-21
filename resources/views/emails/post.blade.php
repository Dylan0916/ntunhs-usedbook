<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<!-- CSS dist/libs -->
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/lib/css/font-awesome.min.css') }}">
<title>Welcome! 北護二手書交易平台</title>

</head>
<body>

<?php $explode_email = explode('@', $email); ?>

<div class="container">
  <h2>感謝您註冊 <span style="color: red;">北護二手書平台</span></h2>
  <h4 style="padding: 15px 0 15px 0;">您的學號為：<span class="text-primary">{{ $explode_email[0] }}</span></h4>
  <a href="{{ url('register/' . $code) }}" class="btn btn-primary" style="font-size: 16px; padding: 10px;">點擊這裡來驗證您的信箱</a>
</div>

</body>
</html>
