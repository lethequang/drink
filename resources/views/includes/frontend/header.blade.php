<?php
$menu_items = \App\Helpers\General::get_menu_items();
$settings = \App\Helpers\General::get_settings();
?>
<!-- ====== BEGIN HEADER ====== -->
<header id="header">
    <!-- Main Menu Header -->
    <nav class="navbar navbar-default navbar-fixed-top-1">
        <div class="container-fluid">
            <!-- Navbar Brand -->
            <div class="navbar-header">
                <a href="{{url('/')}}" id="navbar-brand" class="navbar-brand">
                    <img src="<?=@$settings['image_logo_header']['value']?>" alt="kensington Property"></a>
                <button type="button" class="navbar-toggle btn-menu">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Navbar Menu -->
            <nav id="navbar" class="navbar navbar-right navbar-collapse">
                <ul class="nav navbar-nav">
                <?php
                $base_url = url('/');
                $curr_url = url()->current();
                if ($base_url==$curr_url) {
                    $base_url = '';
                }
                ?>
                @foreach($menu_items as $item)
                    <!-- Dropdown Menu -->
                    <?php
                        if (strpos($item['link_full'], '#')===0) {
                            $item['link_full'] = $base_url.$item['link_full'];
                        }

                        ?>
                    <li{!! $item['link_full']==$curr_url?' class="active"':'' !!}>
                        <a class="scrollLink" href="{{$item['link_full']}}">{{$item['name']}}</a>
                    </li>
                @endforeach
                </ul>
            </nav>
        </div>
    </nav>
</header>
<!-- ====== END HEADER ====== -->