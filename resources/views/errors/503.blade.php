<!DOCTYPE html>
<html lang="vi">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>
    Admin :: HiSDC
  </title>
  <!-- CSS -->
  <link rel="stylesheet" href="/assets/html/css/style.css">

  <!-- Favicons -->
  <link rel="icon" href="/favicon.ico?v=1">
  <style>
    footer {
      position: fixed;
      bottom: 0;
      width: 100%;
    }
  </style>
</head>

<body>
<header class="navbar navbar-default navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/"><img src="https://hisdc.fpt.vn/assets/html/images/system/fpt-logo.png" alt=""></a>
    </div>
  </div>
</header>
<div class="main login">
  <div class="container">
    <div class="col-sm-12" style="padding-top: 40px;">
      <div class="content-introduce content">
        <div class="col-md-6 left-error text-right">
          <img src="/assets/img/gif-bear.gif" alt="">
        </div>
        <div class="col-md-6 right-error text-center">
          <h1 style="font-size: 80px;">503</h1>
          <h2>It's not you, it's me.</h2>
          <p class="decript">
              <?php
              $default_error_message = "Máy chủ đang ngừng hoạt động để bảo trì. Vui lòng trở lại sau.";
              ?>
            {!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <img src="/assets/html/images/system/fpt-logo-white.png" alt=""> &copy; CÔNG TY TNHH MTV VIỄN THÔNG QUỐC TẾ FPT
      </div>
      <div class="col-sm-8 col-md-4 footer-info">
        <ul class="list-inline">
          <li class="list-inline-item">
            <i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i> info@gmail.com
          </li>
          <li class="list-inline-item">
            <i class="fa fa-yelp fa-fw" aria-hidden="true"></i> +123 456 78-90
          </li>
        </ul>
      </div>
      <div class="col-sm-4 col-md-2 footer-social">
        <ul class="list-inline">
          <li class="list-inline-item"><a href="#" class="social social-facebook"><i class="fa fa-facebook"
                                                                                     aria-hidden="true "></i></a>
          </li>
          <li class="list-inline-item"><a href="#" class="social social-twitter"><i class="fa fa-twitter"
                                                                                    aria-hidden="true"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</footer>    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
</body>
</html>