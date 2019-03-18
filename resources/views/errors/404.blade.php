@extends('layouts.frontend')

@section('content')
    <style>
        footer.fixed {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
    <section class="container wp-main-error" style="padding: 100px 0px;">
        <div class="wrap-error">
            <div class="col-md-6 left-error">
                <img src="/html/assets/images/gif-bear.gif" alt="">
            </div>
            <div class="col-md-6 right-error">
                <h1>404</h1>
                <h2>{{__("We did not find your page request")}}</h2>
                <p class="decript">{{__('The this page does not exist or the product were deleted from website.')}} {{__('You can try the following links:')}}</p>
                <ul class="list-link">
                    <li class="item-link">
                        <a href="/" class="home">
                            <p>Về trang chủ</p>
                        </a>
                    </li>
                    <!--
                    <li class="item-link">
                        <a href="/" class="top">
                            <p>{{__('Top 10 best selling products')}}</p>
                        </a>
                    </li>
                    <li class="item-link">
                        <a href="/" class="favorite">
                            <p>{{__('Top brand favorite')}}</p>
                        </a>
                    </li>
                    -->
                </ul>
            </div>
        </div>
    </section>

@endsection