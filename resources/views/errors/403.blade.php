@extends('layouts.admin')
@section('content')
    <div class="container text-center">
      <div class="content">
        <div class="title">403</div>
        <div class="quote">Bạn không có quyền với chức năng này. Vui lòng liên hệ với Admin[TinhDT9] để được hỗ trợ.</div>
        <div class="explanation">
          <br>
          <small>
            <?php
              $default_error_message = "Vui lòng chỉ chọn các chức năng có trên Menu.";
            ?>
            {!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}
         </small>
       </div>
      </div>
    </div>
@endsection
