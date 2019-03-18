<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\Asset;
use App\Models\AssetFeatureValue;
use App\Models\AssetImage;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\SlideShow;

class AssetController extends Controller
{
    protected $data = []; // the information we send to the view

    public function index(Request $request)
    {
        $params = $request->all();
        $limit = $request->input('limit', 10);
        $params['limit'] = $limit;
        $params['type'] = 'lease';

        $assets = Asset::getSearchAssets($params);

        $this->data['params'] = $params;
        $this->data['assets'] = $assets;
        $this->data['type'] = $params['type'];

        return view('frontend.asset.index', $this->data);
    }

    public function buy(Request $request)
    {
        $params = $request->all();
        $limit = $request->input('limit', 10);
        $params['limit'] = $limit;
        $params['type'] = 'buy';

        $assets = Asset::getSearchAssets($params);

        $this->data['params'] = $params;
        $this->data['assets'] = $assets;
        $this->data['type'] = $params['type'];

        $request->request->add([
            'type' => $params['type'],
        ]);

        return view('frontend.asset.index', $this->data);
    }

    public function hot(Request $request)
    {
        $params = $request->all();
        $limit = $request->input('limit', 10);
        $params['limit'] = $limit;
        $params['is_hot'] = 1;

        $assets = Asset::getSearchAssets($params);

        $this->data['params'] = $params;
        $this->data['assets'] = $assets;
        $this->data['type'] = 'hot';

        return view('frontend.asset.index', $this->data);
    }

    public function show(Request $request, $slug, $id)
    {
        $object = Asset::select(['assets.*', 'asset_categories.name as asset_category_name',
            \DB::raw("CONCAT_WS(' ', provinces.type, provinces.name) as province_name"),
            \DB::raw("CONCAT_WS(' ', districts.type, districts.name) as district_name")])
            ->leftJoin('asset_categories', 'asset_categories.id', '=', 'assets.asset_category_id')
            ->leftJoin('provinces', 'provinces.province_id', '=', 'assets.province_id')
            ->leftJoin('districts', 'districts.district_id', '=', 'assets.district_id')
            ->where('assets.id', $id)->first();

        if (!$object) {
            abort(404);
        }
        $this->data['object'] = $object;

        $images = AssetImage::where('assets_images.asset_id', $id)->orderBy('assets_images.id', 'desc')->get();
        $this->data['images'] = $images;

        $asset_features_values = AssetFeatureValue::select([
            'asset_features_values.*', 'asset_features.name as asset_feature_name', 'asset_features.class_icon', 'asset_features.is_show_detail',
            'asset_features_variants.name as variant_name'
        ])
            ->where('asset_id', $id)
            ->leftJoin('asset_features', 'asset_features.id', '=', 'asset_features_values.feature_id')
            ->leftJoin('asset_features_variants', 'asset_features_variants.id', '=', 'asset_features_values.variant_id')
            ->get()->toArray();
        $this->data['asset_features_values'] = $asset_features_values;

        $request->request->add([
            'type' => $object['type'],
            'cid' => $object['asset_category_id'],
            'province' => $object['province_id'],
            'district' => $object['district_id'],
        ]);

        return view('frontend.asset.show', $this->data);
    }
}
