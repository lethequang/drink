<?php
$settings = \App\Helpers\General::get_settings();
$menu_footer = \App\Helpers\General::get_menus_footer();
?>
<footer id="footer" class="fixed">
    <div class="top-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <article class="intro">
                        <h4>TIN THUÊ NHÀ</h4>
                        <div class="about_footer">
                            {!! @$settings['about_footer']['value'] !!}
                        </div>
                    </article>
                </div>
@if (isset($menu_footer[0]))
                @foreach ($menu_footer[0] as $key => $parent)
                    <div class="col-sm-2">
                        <dl>
                            <dt>{!! $parent['name'] !!} </dt>
                        @if (isset($menu_footer[$parent['id']]))
                            @foreach ($menu_footer[$parent['id']] as $value)
                            <dd><a href="{{  $value['link_full'] }}">{{ $value['name'] }}</a></dd>
                            @endforeach
                        @endif
                        </dl>
                    </div>
                @endforeach
@endif
                <div class="col-sm-3">
                    <article class="art-fanpage">
                        <h4>KẾT NỐI VỚI CHÚNG TÔI</h4>
                        {!! @$settings['fanpage_facebook']['value'] !!}
                    </article>
                </div>
            </div>
        </div>

    </div>
    <div class="copyright">
        <div class="container clearfix">
            <p><?=@$settings['copyright']['value']?></p>

            <ul class="list-social">
                <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo URL::current(); ?>"
                       onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;"
                       class="btn-floating btn-large btn-fb">
                        <i class="fa fa-facebook"></i></a></li>
                <li><a href="http://twitter.com/share"
                       onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;"
                       class="btn-floating btn-large btn-tw">
                        <i class="fa fa-twitter"></i></a></li>
                <li><a href="https://plus.google.com/share?url=<?php echo URL::current(); ?>"
                       onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;"
                       class="btn-floating btn-large btn-gplus">
                        <i class="fa fa-google-plus"></i></a></li>
            </ul>
        </div>
    </div>
</footer>
<a href="javascript:void(0)" title="top" class="btn-top"><i class="fa fa-caret-up"></i></a>