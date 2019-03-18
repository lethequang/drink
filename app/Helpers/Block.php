<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use \App\Models\HomeBlock;

class Block
{
    public static function form_search()
    {
        return view('frontend.blocks.form-search', []);
    }

    public static function assets_buy($limit=8)
    {
        $assets_buy = \App\Models\Asset::getTopAssetsByType('buy', $limit);

        return view('frontend.blocks.assets-buy', ['assets_buy' => $assets_buy]);
    }

    public static function assets_lease($limit=8)
    {
        $assets_lease = \App\Models\Asset::getTopAssetsByType('lease', $limit);

        return view('frontend.blocks.assets-lease', ['assets_lease' => $assets_lease]);
    }

    public static function assets_hot()
    {
        $assets_hot = \App\Models\Asset::getAssetsHot(4);

        return view('frontend.blocks.assets-hot', ['assets_hot' => $assets_hot]);
    }

    public static function assets_hot_panel()
    {
        $ac = General::get_controller_action();
        if ($ac['action']=='hot') {
            return '';
        }

        $assets_hot = \App\Models\Asset::getAssetsHot(8);
        return view('frontend.blocks.assets-hot-panel', ['assets_hot' => $assets_hot]);
    }

    public static function property_item_content($item, $view=null)
    {
        if (!$item) {
            return '';
        }

        if ($view) {
            return view('frontend.blocks.property-item-content-'.$view, ['item' => $item]);
        }

        return view('frontend.blocks.property-item-content', ['item' => $item]);
    }

    public static function fengshui_item($item, $class='')
    {
        if (!$item) {
            return '';
        }

        if (!is_array($item)) {
            $item = $item->toArray();
        }

        return view('frontend.blocks.fengshui-item', ['item' => $item, 'class' => $class]);
    }

    public static function news_item($item)
    {
        if (!$item) {
            return '';
        }

        if (!is_array($item)) {
            $item = $item->toArray();
        }

        return view('frontend.blocks.news-item', ['item' => $item]);
    }

    public static function property_item($item)
    {
        if (!$item) {
            return '';
        }

        if (!is_array($item)) {
            $item = $item->toArray();
        }

        return view('frontend.blocks.property-item', ['item' => $item]);
    }

    public static function show_contact_item()
    {
        $item = \App\Models\Support::getContact();

        return view('frontend.blocks.contact', ['item' => $item]);
    }

    public static function slider()
    {
        $item = \App\Models\SlideShow::getSlideShows();
        return view('frontend.blocks.slider', ['sliders' => $item]);
    }

    public static function get_link_article($item=null)
    {
        if (!$item) {
            return '';
        }

        if (!is_array($item)) {
            $item = $item->toArray();
        }

        return route('fe.article.show', ['slug' => str_slug(@$item['name']), 'id' => @$item['id']]);
    }

    public static function breadcrumb($data=array())
    {
        return view('frontend.blocks.breadcrumb', ['breadcrumb' => $data]);
    }

    public static function get_breadcrumb_link($cate_id)
    {
        if (!$cate_id) {
            return '';
        }
        if($cate_id == 1)
            return route('fe.article.index');
        return route('fe.article.fengshui');
    }

    public static function get_link_asset($item=null)
    {
        if (!$item) {
            return '';
        }

        if (!is_array($item)) {
            $item = $item->toArray();
        }

        return route('fe.asset.show', ['slug' => str_slug(@$item['name']), 'id' => @$item['id']]);
    }

    public static function get_link_asset_category($item=null)
    {
        if (!$item) {
            return '';
        }

        if (!is_array($item)) {
            $item = $item->toArray();
        }

        $params = isset($item['asset_category_id']) ? ['cid' => $item['asset_category_id']] : [];

        if ($item['type'] == 'lease') {
            return route('fe.asset.lease', $params);
        }

        return route('fe.asset.buy', $params);
    }
}
