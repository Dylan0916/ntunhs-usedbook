@extends('layouts.main')
@section('content')

  <!-- Styles -->
<style>
    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }
    .content {
        text-align: center;
        font-family: 'Raleway';
        color: #636b6f;
    }
    .content .m-b-md {
        margin-top: 90px;
        font-size: 84px;
        font-weight: bolder;
    }
    .content .notpage {
        margin: 20px 0 70px 0;
    }
</style>

<div class="flex-center position-ref">
    <div class="content">
        <div class="m-b-md">Error 404</div>
        <p class="notpage">Woops, Loks like this page doesn't exist.</p>
    </div>
</div>

@endsection
