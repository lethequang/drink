<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<?php
$user = \App\Helpers\Auth::getUserInfo();
$permissions = \App\Helpers\Auth::get_permissions();
$ac = \App\Helpers\General::get_controller_action();
?>

<li><a href="{{backpack_url('dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

 <?php
            $hp = \App\Helpers\Auth::has_permission('article.index', $user, $permissions);
            if ($hp) {
            $active = $ac['controller']=='ArticleController'
                || $ac['controller']=='ArticlesCrawlerController'
                || $ac['controller']=='CrawlerControler'
                    ?' active':'';
            ?>
<li class="treeview<?=$active?>">
    <a href="#">
        <i class="fa fa-newspaper-o"></i><span>QL Bài viết</span>
        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
        <?php
        $hp = \App\Helpers\Auth::has_permission('article.index', $user, $permissions);
        if ($hp) {
        $sub_active = $active && $ac['controller']=='ArticleController' ?' class="active"':'';
        ?>
        <li<?=$sub_active?>><a href="{{route('article.index')}}"><i class="fa fa-archive"></i> <span>Danh sách</span></a></li>
        <?php } ?>

            <?php
            $hp = \App\Helpers\Auth::has_permission('article.create', $user, $permissions);
            if ($hp) {
            $sub_active = $active && $ac['controller']=='ArticleController' ?' class="active"':'';
            ?>
            <li<?=$sub_active?>><a href="{{route('article.create')}}"><i class="glyphicon glyphicon-plus"></i> <span>Thêm bài viết</span></a></li>
            <?php } ?>
    </ul>
</li>

            <?php } ?>


            <?php
            $hp = \App\Helpers\Auth::has_permission(['customers.index', 'customer-roles.index'], $user, $permissions);
            if ($hp) {
            $active =
                $ac['controller']=='CustomerController'
                || $ac['controller']=='CustomerRolesController'
                    ?' active menu-open':''
            ?>

<li class="treeview<?=$active?>">
    <a href="#">
        <i class="fa fa-users"></i> <span>Khách hàng</span>
        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
        <?php
        $hp = \App\Helpers\Auth::has_permission('customers.index', $user, $permissions);
        if ($hp) {
        $sub_active = $active && $ac['controller']=='CustomerController' ?' class="active"':'';
        ?>
        <li<?=$sub_active?>><a href="<?=route('customers.index')?>"><i class="fa fa-user-secret"></i> Danh sách</a></li>
        <?php } ?>

        <?php
        $hp = \App\Helpers\Auth::has_permission('customer-roles.index', $user, $permissions);
        if ($hp) {
        $sub_active = $active && $ac['controller']=='CustomerRolesController' ?' class="active"':'';
        ?>
        <li<?=$sub_active?>><a href="<?=route('customer-roles.index')?>"><i class="fa fa-heart"></i> Hạng khách hàng</a></li>
        <?php } ?>
    </ul>
</li>
<?php } ?>


            <?php
            $hp = \App\Helpers\Auth::has_permission(['asset.index', 'asset-feature.index', 'asset-feature-variant.index', 'asset-category.index' ], $user, $permissions);
            if ($hp) {
            $active =
                $ac['controller']=='AssetController'
                || $ac['controller']=='AssetFeatureController'
                || $ac['controller']=='AssetFeatureVariantController'
                || $ac['controller']=='AssetCategoryController'

                    ?' active menu-open':''
            ?>

<li class="treeview<?=$active?>">
    <a href="#">
        <i class="fa fa-barcode"></i> <span>QL Sản phẩm</span>
        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
        <?php
        $hp = \App\Helpers\Auth::has_permission('asset.index', $user, $permissions);
        if ($hp) {
        $active = $ac['controller']=='AssetController'
            ?' active':'';
        ?>
        <li class="<?=$active?>"><a href="{{route('asset.index')}}"><i class="fa fa-list"></i> <span>Sản phẩm</span></a></li>
        <?php } ?>

            <?php
            $hp = \App\Helpers\Auth::has_permission('asset.create', $user, $permissions);
            if ($hp) {
            $sub_active = $active && $ac['controller']=='AssetController' ?' class="active"':'';
            ?>
            <li<?=$sub_active?>><a href="{{route('asset.create')}}"><i class="glyphicon glyphicon-plus"></i> <span>Thêm sản phẩm</span></a></li>
            <?php } ?>

        <?php
        $hp = \App\Helpers\Auth::has_permission('asset-feature.index', $user, $permissions);
        if ($hp) {
        $active = $ac['controller']=='AssetFeatureController'
            ?' active':'';
        ?>
        <li class="<?=$active?>"><a href="{{route('asset-feature.index')}}"><i class="fa fa-filter"></i> <span>QL Thuộc tính</span></a></li>
        <?php } ?>

        <?php
        $hp = \App\Helpers\Auth::has_permission('asset-feature-variant.index', $user, $permissions);
        if ($hp) {
        $active = $ac['controller']=='AssetFeatureVariantController'
            ?' active':'';
        ?>
        <li class="<?=$active?>"><a href="{{route('asset-feature-variant.index')}}"><i class="fa fa-filter"></i> <span>QL Giá trị thuộc tính</span></a></li>
        <?php } ?>

        <?php
        $hp = \App\Helpers\Auth::has_permission('asset-category.index', $user, $permissions);
        if ($hp) {
        $active = $ac['controller']=='AssetCategoryController'
            ?' active':'';
        ?>
        <li class="<?=$active?>"><a href="{{route('asset-category.index')}}"><i class="fa fa-list"></i> <span>QL Danh mục sản phẩm</span></a></li>
        <?php } ?>


    </ul>
</li>

<?php } ?>

<?php
$hp = \App\Helpers\Auth::has_permission(['promotion.index', 'promotion-feature.index', 'promotion-feature-variant.index', 'promotion-category.index' ], $user, $permissions);
if ($hp) {
$active =
    $ac['controller']=='PromotionController'
    || $ac['controller']=='PromotionFeatureController'
    || $ac['controller']=='PromotionFeatureVariantController'

        ?' active menu-open':''
?>

<li class="treeview<?=$active?>">
    <a href="#">
        <i class="glyphicon glyphicon-gift"></i> <span>QL Khuyến mãi</span>
        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
        <?php
        $hp = \App\Helpers\Auth::has_permission('promotion.index', $user, $permissions);
        if ($hp) {
        $active = $ac['controller']=='PromotionController'
            ?' active':'';
        ?>
        <li class="<?=$active?>"><a href="{{route('promotion.index')}}"><i class="fa fa-list"></i> <span>Danh sách</span></a></li>
        <?php } ?>

        <?php
        $hp = \App\Helpers\Auth::has_permission('promotion-feature.index', $user, $permissions);
        if ($hp) {
        $active = $ac['controller']=='PromotionFeatureController'
            ?' active':'';
        ?>
        <li class="<?=$active?>"><a href="{{route('promotion-feature.index')}}"><i class="fa fa-filter"></i> <span>QL Thuộc tính</span></a></li>
        <?php } ?>

        <?php
        $hp = \App\Helpers\Auth::has_permission('promotion-feature-variant.index', $user, $permissions);
        if ($hp) {
        $active = $ac['controller']=='PromotionFeatureVariantController'
            ?' active':'';
        ?>
        <li class="<?=$active?>"><a href="{{route('promotion-feature-variant.index')}}"><i class="fa fa-filter"></i> <span>QL Giá trị thuộc tính</span></a></li>
        <?php } ?>




    </ul>
</li>

<?php } ?>


<?php
$hp = \App\Helpers\Auth::has_permission(['asset.index', 'asset-feature.index', 'asset-feature-variant.index', 'asset-category.index' ], $user, $permissions);
if ($hp) {
$active =
    $ac['controller']=='AssetController'
    || $ac['controller']=='AssetFeatureController'
    || $ac['controller']=='AssetFeatureVariantController'
    || $ac['controller']=='AssetCategoryController'

        ?' active menu-open':''
?>


<li class="treeview<?=$active?>">
    <a href="#">
        <i class="glyphicon glyphicon-shopping-cart"></i> <span>QL Đơn hàng</span>
        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
        <?php
        $hp = \App\Helpers\Auth::has_permission('order.index', $user, $permissions);
        if ($hp) {
        $active = $ac['controller']=='OrderController'
            ?' active':'';
        ?>
        <li class="<?=$active?>"><a href="{{route('order.index')}}"><i class="fa fa-list"></i> <span>Danh sách</span></a></li>
        <?php } ?>


            <?php
            $hp = \App\Helpers\Auth::has_permission('order.create', $user, $permissions);
            if ($hp) {
            $sub_active = $active && $ac['controller']=='OrderController' ?' class="active"':'';
            ?>
            <li<?=$sub_active?>><a href="{{route('order.create')}}"><i class="glyphicon glyphicon-plus"></i> <span>Thêm đơn hàng</span></a></li>
            <?php } ?>



    </ul>
</li>
<?php } ?>

 <?php
            $hp = \App\Helpers\Auth::has_permission('support.index', $user, $permissions);
            if ($hp) {
            $active = $ac['controller']=='SupportController'
                ?' active':'';
            ?>
            <li class="<?=$active?>"><a href="{{route('support.index')}}"><i class="fa fa-phone"></i> <span>QL Hỗ trợ tực tuyến</span></a></li>
            <?php } ?>

 <?php
            $hp = \App\Helpers\Auth::has_permission('contact.index', $user, $permissions);
            if ($hp) {
            $active = $ac['controller']=='ContactController'
                ?' active':'';
            ?>
            <li class="<?=$active?>"><a href="{{route('contact.index')}}"><i class="fa fa-list"></i> <span>Danh sách yêu cầu liên hệ</span></a></li>
            <?php } ?>

            <?php
            $hp = \App\Helpers\Auth::has_permission('page.index', $user, $permissions);
            if ($hp) {
            $active = $ac['controller']=='PageController'
                ?' active':'';
            ?>
            <li class="<?=$active?>"><a href="{{backpack_url('page') }}"><i class="fa fa-file-o"></i> <span>Trang tĩnh</span></a></li>
            <?php } ?>

            <?php
            $hp = \App\Helpers\Auth::has_permission(['banner.index', 'slide-show.index'], $user, $permissions);
            if ($hp) {
            $active =
                $ac['controller']=='BannerController'
                || $ac['controller']=='SlideShowController'
                    ?' active menu-open':''
            ?>
<li class="treeview<?=$active?>">
    <a href="#">
        <i class="fa fa-picture-o"></i> <span>Quản lý hình ảnh</span>
        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
        <?php
        $hp = \App\Helpers\Auth::has_permission('banner.index', $user, $permissions);
        if ($hp) {
        $active = $ac['controller']=='BannerController'
            ?' active':'';
        ?>
        <li class="<?=$active?>"><a href="{{backpack_url('banner') }}"><i class="fa fa-bullhorn"></i> <span>Banners quảng cáo</span></a></li>
        <?php } ?>

            <?php
            $hp = \App\Helpers\Auth::has_permission('slide-show.index', $user, $permissions);
            if ($hp) {
            $active = $ac['controller']=='SlideShowController'
                ?' active':'';
            ?>
            <li class="<?=$active?>"><a href="{{backpack_url('slide-show') }}"><i class="fa fa-picture-o"></i> <span>QL Slide Show</span></a></li>
            <?php } ?>
    </ul>
</li>
<?php } ?>

            <?php
            $hp = \App\Helpers\Auth::has_permission(['slide-show.index', 'setting.index'], $user, $permissions);
            if ($hp) {
            $active =
                $ac['controller']=='MenuItemCrudController'
                || $ac['controller']=='SettingCrudController'
                    ?' active menu-open':''
            ?>
<li class="treeview<?=$active?>">
    <a href="#">
        <i class="fa fa-cog"></i> <span>Cài đặt</span>
        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
            <?php
            $hp = \App\Helpers\Auth::has_permission('slide-show.index', $user, $permissions);
            if ($hp) {
            $active = $ac['controller']=='MenuItemCrudController'
                ?' active':'';
            ?>
            <li class="<?=$active?>"><a href="{{backpack_url('menu-item') }}"><i class="fa fa-list-ol"></i> <span>Menu Items</span></a></li>
            <?php } ?>

            <?php
            $hp = \App\Helpers\Auth::has_permission('setting.index', $user, $permissions);
            if ($hp) {
            $active = $ac['controller']=='SettingCrudController'
                ?' active':'';
            ?>
            <li><a href="{{backpack_url('setting') }}"><i class="fa fa-cog"></i> <span>Cài đặt</span></a></li>
            <?php } ?>
    </ul>
</li>
<?php } ?>

<?php
$hp = \App\Helpers\Auth::has_permission(['users.index', 'roles.index'], $user, $permissions);
if ($hp) {
$active =
    $ac['controller']=='UserController'
    || $ac['controller']=='RolesController'
        ?' active menu-open':''
?>

<li class="treeview<?=$active?>">
    <a href="#">
        <i class="fa fa-users"></i> <span>Người dùng</span>
        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
    <ul class="treeview-menu">
        <?php
        $hp = \App\Helpers\Auth::has_permission('users.index', $user, $permissions);
        if ($hp) {
        $sub_active = $active && $ac['controller']=='UserController' ?' class="active"':'';
        ?>
        <li<?=$sub_active?>><a href="<?=route('users.index')?>"><i class="fa fa-user-secret"></i> Danh sách</a></li>
        <?php } ?>

        <?php
        $hp = \App\Helpers\Auth::has_permission('roles.index', $user, $permissions);
        if ($hp) {
        $sub_active = $active && $ac['controller']=='RolesController' ?' class="active"':'';
        ?>
        <li<?=$sub_active?>><a href="<?=route('roles.index')?>"><i class="fa fa-user-secret"></i> Vài trò người dùng</a></li>
        <?php } ?>
    </ul>
</li>
<?php } ?>

<li class="header"></li>
<li>
    <a href="{{ route('backpack.auth.logout') }}"
       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out"></i> <span>{{ __('Logout') }}</span>
    </a>
</li>
