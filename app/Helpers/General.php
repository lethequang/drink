<?php

namespace App\Helpers;

use App\Models\Article;
use App\Models\MenuItem;
use App\Models\Partner;
use App\Models\AssetFeature;
use App\Models\ProductCategory;
use App\Models\Manufacturer;
use App\Models\Support;
use App\Models\ArticleCategory;

use Illuminate\Support\Facades\Cache;

class General
{
    public static function move_image($folder, $image) {
        /**
         * Path to the 'public' folder
         */
        $path_image = '/uploads/cke/'.$folder;
        $path = public_path($path_image);

        // tao thu muc
        if (! is_dir ( $path )) {
            mkdir ( $path, 0777, true );
            if( chmod($path, 0777) ) {
                // more code
                chmod($path, 0755);
            }
        }

        $rs = '';
        if (file_exists(public_path().$image)) {
            rename(public_path().$image, $path.'/'.basename($image));
            $rs = $path_image.'/'.basename($image);
        }

        if (file_exists(public_path().$image)) unlink(public_path().$image);

        return $rs;
    }

    public static function key_address_default()
    {
        return 'address_default';
    }

    public static function getAddressByDistrict($district_id, $ward = null)
    {
        $ward = $ward ? $ward : \App\Models\District::select(
            \DB::raw("CONCAT_WS(' ', provinces.type, provinces.name) as province_name"),
            \DB::raw("CONCAT_WS(' ', districts.type, districts.name) as district_name")
        )
            ->where('district_id', $district_id)
            ->leftJoin('provinces', 'provinces.province_id', '=', 'districts.province_id')
            ->first();

        $address = [];
        if ($ward['province_name']) {
            $address[] = $ward['province_name'];
        }

        if ($ward['district_name'] && strpos($address[0], $ward['district_name']) === false) {
            $address[] = $ward['district_name'];
        }

        if (isset($ward['ward_name'])) {
            $address[] = $ward['ward_name'];
        }

        $address = implode(", ", array_reverse($address));
        return $address;
    }

    public static function getBannersByPage($page='home', $re_cache = false)
    {
        $key = 'BannersByPage:'.(is_array($page) ? md5(json_encode($page)) : $page);

        $objects = Cache::get($key);

        if ($re_cache || !$objects) {
            $objects = \App\Models\Banner::getBannersByPage($page);

            Cache::forever($key, $objects);
        }

        return $objects;
    }

    public static function get_assets_categories($type = 'lease', $re_cache = false)
    {
        $key = 'AssetCategory:All';

        $objects = Cache::get($key);

        if ($re_cache || !$objects) {
            $objects = \App\Models\AssetCategory::getAssetCategories();

            Cache::forever($key, $objects);
        }

        return $objects[$type] ?? [];
    }

    public static function get_assets_feature()
    {
        $assetFeatures = AssetFeature::where(['status' => 1, 'is_deleted' => 0, 'is_show_detail' => 1])
            ->orderBy('id', 'desc')
            ->get();

        return $assetFeatures;
    }

    public static function get_assets_prices($re_cache = false)
    {
        $key = 'AssetFeaturePrices';

        $objects = Cache::get($key);

        if ($re_cache || !$objects) {
            $feature_price = self::get_settings('feature_price_id');

            $objects = \App\Models\AssetFeatureVariant::getVariantsOptions($feature_price['value'] ?? 0);

            Cache::forever($key, $objects);
        }

        return $objects ?? [];
    }

    public static function get_scripts_include($type = 'body', $re_cache = false)
    {
        $key = 'ScriptInclude:All';

        $objects = Cache::get($key);

        if ($re_cache || !$objects) {
            $objects = \App\Models\ScriptInclude::getAllScripts();

            Cache::forever($key, $objects);
        }

        foreach ($objects as $item) {
            if (!isset($item['type']) || $item['type'] === $type) {
                echo $item['value'];
            }
        }
    }

    public static function telegram_log($content)
    {
        //            $url = 'https://api.telegram.org/bot545339852:AAH9-wfIRfeWX19P7uPvrHPrGho57CuIunc/getUpdates'; dùng get chat id
        $url = 'https://api.telegram.org/bot545339852:AAH9-wfIRfeWX19P7uPvrHPrGho57CuIunc/sendMessage';
        $url .= '?chat_id=-251432008';
        $url .= '&text=' . urlencode(env("APP_NAME")) . ': ' . $content;

        $res = \Ixudra\Curl\Facades\Curl::to($url)->get();
    }

    public static function get_link_menu($item, $locale = '')
    {
        if ($item['type'] == 'page_link') {
            $tmp = $locale . '/' . $item['page_slug'];
        } elseif ($item['type'] == 'internal_link') {
            $tmp = $locale . $item['link'];
        } else {
            $tmp = $item['link'];
        }

        return url($tmp ? $tmp : '/');
    }

    public static function get_assets_sort_options()
    {
        return [
            'latest' => 'Tin mới nhất',
            'price-asc' => 'Giá thấp đến cao',
            'price-desc' => 'Giá cao đến thấp',
            'acreage-asc' => 'Diện tích nhỏ đến lớn',
            'acreage-desc' => 'Diện tích lớn đến nhỏ',
        ];
    }

    public static function get_assets_types_titles()
    {
        return [
            'hot' => 'Tin nổi bật',
            'lease' => 'Nhà đất cho thuê',
            'buy' => 'Nhà đất cần thuê',
        ];
    }

    public static function get_limit_options()
    {
        return [
            '10' => '10 dòng/Trang',
            '20' => '20 dòng/Trang',
            '30' => '30 dòng/Trang',
            '40' => '40 dòng/Trang',
            '50' => '50 dòng/Trang',
        ];
    }

    public static function get_menu_items($position = 'main', $re_cache = false)
    {
        $key = 'MenuItems:Position:' . $position;
        $objects = Cache::get($key);

        if ($re_cache || !$objects) {
            $objects = \App\Models\MenuItem::select('menu_items.*', 'p.slug as page_slug')
                ->leftjoin('pages as p', 'p.id', '=', 'menu_items.page_id')
                ->where('menu_items.position', $position)
                ->orderBy('lft', 'asc')->get()->toArray();

            foreach ($objects as $index => $item) {
                $objects[$index]['link_full'] = self::get_link_menu($item);
            }

            Cache::forever($key, $objects);
        }

        return $objects;
    }

    public static function get_menus_footer($parentId = null)
    {
        $footer = self::get_menu_items('footer');

        $tmp = [];
        foreach ($footer as $item) {
            $tmp[intval($item['parent_id'])][] = $item;
        }

        return $tmp;
    }

    public static function get_settings($name = null, $re_cache = false)
    {
        $key = 'Settings:All';

        $objects = Cache::get($key);

        if ($re_cache || !$objects) {
            $objects = \App\Models\Setting::getAllSettings();

            Cache::forever($key, $objects);
        }

        if ($name) {
            return @$objects[$name];
        }

        return $objects;
    }

    public static function getCurrencies()
    {
        return array(
            'VNĐ' => 'VNĐ',
            'USD' => 'USD',
        );
    }

    public static function output_date_public($date_public, $created_at, $format = 'd/m/Y')
    {
        return self::format_show_date($date_public ?? $created_at, $format);
    }

    public static function format_show_date($date, $format = 'd/m/Y')
    {
        if (!$date || $date == '0000-00-00') {
            return '';
        }

        return date($format, strtotime($date));
    }

    public static function get_controller_action()
    {
        $action = app('request')->route()->getAction();

        $route = isset($action['as']) ? $action['as'] : '';

        $controller = class_basename($action['controller']);

        list($controller, $action) = explode('@', $controller);

        if (!$route) {
            $route = strtolower(str_replace('Controller', '', $controller)) . '.' . $action;
        }

        return array(
            'controller' => $controller,
            'action' => $action,
            'as' => $route
        );
    }

    public static function get_data_fillable($model, $data)
    {
        $fillable = $model->getFillable();

        $rs = [];

        foreach ($fillable as $field) {
            if (isset($data[$field])) {
                $rs[$field] = $data[$field];
            }
        }

        return $rs;
    }

    public static function saveDocumentFile($filename, $path)
    {
        if (empty($filename)) {
            return '';
        }

        $root = rtrim(public_path(), '/') . '/';

        // file goc
        $path_file = realpath($root . "uploads/tmp/" . $filename);

        if (file_exists($path_file)) {

            // tao thu muc
            if (!is_dir($root . $path)) {
                mkdir($root . $path, 0777, true);
                if (chmod($root . $path, 0777)) {
                    // more code
                    chmod($root . $path, 0755);
                }
            }

            // file dich
            $info = pathinfo($path_file);
            $filename = $path . time() . '-' . str_slug(basename($path_file, '.' . $info['extension']), '-') . '.' . $info['extension'];

            rename($path_file, $root . $filename);

            // xoa hinh tmp
            @unlink($path_file);
//            $filename = url($filename);

            return array('url' => url('/'), 'filename' => $filename);
        }

        return '';
    }

    public static function get_version_js_data($re_cache = false)
    {
        $key = 'get_version_js_data';

        $value = Cache::get($key);

        if ($re_cache || !$value) {
            $value = time();

            Cache::forever($key, $value);
        }

        return $value;
    }

    public static function get_version_js($re_cache = false)
    {
        $key = 'get_version_js';

        $value = Cache::get($key);

        if ($re_cache || !$value) {
            $value = time();

            Cache::forever($key, $value);
        }

        return $value;
    }

    public static function get_version_css($re_cache = false)
    {
        $key = 'get_version_css';

        $value = Cache::get($key);

        if ($re_cache || !$value) {
            $value = time();

            Cache::forever($key, $value);
        }

        return $value;
    }

    public static function get_partners($re_cache = false)
    {
        $key = 'Partner:All';

        $objects = Cache::get($key);

        if ($re_cache || !$objects) {
            $objects = Partner::where('is_deleted', 0)
                ->orderBy('position', 'asc')
                ->orderBy('updated_at', 'desc')
                ->get()->toArray();

            Cache::forever($key, $objects);
        }

        return $objects;
    }

    public static function get_supports($re_cache = false)
    {
        $key = 'Support:All';

        $objects = Cache::get($key);

        if ($re_cache || !$objects) {
            $objects = Support::where('is_deleted', 0)
                ->orderBy('updated_at', 'desc')
                ->get()->toArray();

            Cache::forever($key, $objects);
        }

        return $objects;
    }

    public static function getOrderOptions()
    {
        $orderArr = [];
        for ($i = 1; $i <= 20; $i++) {
            $orderArr[$i] = $i;
        }
        return $orderArr;
    }

    public static function getManufacturer()
    {
        $objects = Manufacturer::where('is_deleted', 0)->pluck('name', 'id');

        return $objects ? $objects->toArray() : [];
    }

    public static function getProductCategories()
    {
        $objects = ArticleCategory::where('is_deleted', 0)
            ->orderBy('order', 'asc')->get()->toArray();

        $rs = [];

        foreach ($objects as $item) {
            $rs[$item['manufacturer_id']][] = $item;
        }

        return $rs;
    }

    public static function getCategoryArticles()
    {
        $data = ArticleCategory::select('id', 'name')->pluck('name', 'id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return array();
    }

    public static function getMenuItems()
    {
        $objects = Manufacturer::where('is_deleted', 0)->get();
        $data = array();
        foreach ($objects as $object) {
            $object = $object->toArray();


            $sub_items = self::checkCategory($object['id']);

            if ($sub_items['rs'] == true) {
                $object['is_has_sub'] = 1;
            } else {
                $object['is_has_sub'] = 0;
            }

            $object['sub_menu_items'] = $sub_items['data'];


            $data[] = $object;
        }

        return $data;
    }

    public static function getArticles()
    {
        $objects = Article::where('is_deleted', 0)
            ->where('status', 1)
            ->orderBy('order', 'asc')->get()->toArray();

        $rs = [];

        foreach ($objects as $item) {
            $rs[$item['category_id']][] = $item;
        }

        return $rs;
    }

    public static function checkCategory($manufacturer_id)
    {
        $objects = ProductCategory::where('is_deleted', 0)->where('manufacturer_id', $manufacturer_id)->get();
        $data = [];
        if (count($objects)) {
            $data['rs'] = true;
            foreach ($objects as $item) {
                $data['data'][] = $item->toArray();
            }
        } else {
            $data['rs'] = false;
            $data['data'] = [];
        }
        return $data;
    }

    public static function getProductSubMenuItems()
    {
        $objects = ProductCategory::where('is_deleted', 0)->get();
        $data = array();
        foreach ($objects as $object) {
            $data[] = $object->toArray();
        }
        return $data;
    }

    public static function isRange()
    {
        return array(
            '0' => 'Không',
            '1' => 'Có',
        );
    }

    public static function toSlug($str)
    {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return $str;
    }
     public static function getOptionGender() {
        return  array(
            '1'       => 'Nam',
            '0'     => 'Nữ',
            'other'      => 'Khác',
        );
    }
}
