<?php
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\District;

class Promotion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'promotion';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description', 'position', 'content', 'asset_category_id',
        'date_from', 'date_to', 'status', 'created_by', 'updated_by',
        'status', 'created_at', 'updated_at', 'is_deleted'];

//    protected $hidden = ['parent_id', 'is_deleted'];

    public static function getListAll($filter)
    {
        $scope = [
            'promotion.*', 'districts.name as districtname', 'provinces.name as provincename', 'asset_categories.name as assetCateName'
        ];

        $sql = self::select($scope)

       ->leftJoin('provinces', 'provinces.province_id', '=', 'assets.province_id')
        ->leftJoin('districts', 'districts.district_id', '=', 'assets.district_id')
        ->leftJoin('asset_categories', 'asset_categories.id', '=', 'assets.asset_category_id');
       

        $sql->where('assets.is_deleted', 0);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('assets.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (isset($filter['status'])) {
            $sql->where('assets.status', $filter['status']);
        }
        if (isset($filter['province_id'])) {
            $sql->where('assets.province_id', $filter['province_id']);
        }

        if (isset($filter['asset_category_id'])) {
            $sql->where('assets.asset_category_id', $filter['asset_category_id']);
        }


        $total = $sql->count();

       
        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
            ->orderBy($filter['sort'], $filter['order'])
            ->get()
            ->toArray();
      

        return ['total' => $total, 'data' => $data];
    }

    public static function getAssetsHot($limit=4)
    {
        $query = self::select(['assets.*', 'asset_categories.name as asset_category_name',
            \DB::raw("CONCAT_WS(' ', provinces.type, provinces.name) as province_name"), \DB::raw("CONCAT_WS(' ', districts.type, districts.name) as district_name")])
            ->leftJoin('asset_categories', 'asset_categories.id', '=', 'assets.asset_category_id')
            ->leftJoin('provinces', 'provinces.province_id', '=', 'assets.province_id')
            ->leftJoin('districts', 'districts.district_id', '=', 'assets.district_id');

        $query->where('assets.is_deleted', 0);
        $query->where('assets.is_hot', 1);
        $query->where('assets.status', 1);

        $query->orderBy('assets.position', 'asc');
        $query->orderBy('assets.id', 'desc');

        return $query->limit($limit)->get();
    }

    public static function getTopAssetsByType($type='lease', $limit=4)
    {
        $query = self::select(['assets.*', 'asset_categories.name as asset_category_name',
            \DB::raw("CONCAT_WS(' ', provinces.type, provinces.name) as province_name"), \DB::raw("CONCAT_WS(' ', districts.type, districts.name) as district_name")])
            ->leftJoin('asset_categories', 'asset_categories.id', '=', 'assets.asset_category_id')
            ->leftJoin('provinces', 'provinces.province_id', '=', 'assets.province_id')
            ->leftJoin('districts', 'districts.district_id', '=', 'assets.district_id');

        $query->where('assets.is_deleted', 0);
        $query->where('assets.is_hot', 1);
        $query->where('assets.status', 1);
        $query->where('assets.type', $type);

        $query->orderBy('assets.position', 'asc');
        $query->orderBy('assets.id', 'desc');

        return $query->limit($limit)->get();
    }

    public static function getSearchAssets($params)
    {
        $query = self::select(['assets.*', 'asset_categories.name as asset_category_name',
            \DB::raw("CONCAT_WS(' ', provinces.type, provinces.name) as province_name"),
            \DB::raw("CONCAT_WS(' ', districts.type, districts.name) as district_name")])
            ->leftJoin('asset_categories', 'asset_categories.id', '=', 'assets.asset_category_id')
            ->leftJoin('provinces', 'provinces.province_id', '=', 'assets.province_id')
            ->leftJoin('districts', 'districts.district_id', '=', 'assets.district_id')
            ->where(['assets.status' => 1, 'assets.is_deleted' => 0]);
            
        if (isset($params['kw'])) {
            $query->where('assets.name', 'LIKE', '%' . $params['kw'] . '%');
        }

        if (isset($params['province'])) {
            $query->where('assets.province_id', $params['province']);
        }

        if (isset($params['is_hot'])) {
            $query->where('assets.is_hot', $params['is_hot']);
        }

        if (isset($params['type'])) {
            $query->where('assets.type', $params['type']);
        }

        if (isset($params['cid'])) {
            $query->where('assets.asset_category_id', $params['cid']);
        }

        if (isset($params['fv'])) {
                foreach ($params['fv'] as  $fv => $v) {
                    if (!$v) {
                        unset($params['fv'][$fv]);
                    }
                }

            if ($params['fv']) {
                $query->whereExists(function ($query_price) use ($params) {
                    $query_price->select(\DB::raw(1))
                        ->from('asset_features_values')
                        ->whereRaw('asset_features_values.asset_id = assets.id')
                        ->whereIn('asset_features_values.feature_id', array_keys($params['fv']))
                        ->whereIn('asset_features_values.variant_id', array_values($params['fv']));
                });
            }
        }

        if (isset($params['price'])) {
            $feature_price = \App\Helpers\General::get_settings('feature_price_id');
            $feature_price = $feature_price['value']??0;

            $query->whereExists(function ($query_price) use ($feature_price, $params) {
                $query_price->select(\DB::raw(1))
                    ->from('asset_features_values')
                    ->whereRaw('asset_features_values.asset_id = assets.id')
                    ->where('asset_features_values.feature_id', $feature_price)
                    ->where('asset_features_values.variant_id', $params['price']);
            });
        }

        if (isset($params['acreage_from']) || isset($params['acreage_to'])) {
            $feature_acreage = \App\Helpers\General::get_settings('feature_acreage_id');
            $feature_acreage = $feature_acreage['value']??0;

            $query->whereExists(function ($query_acreage) use ($feature_acreage, $params) {
                $query_acreage->select(\DB::raw(1))
                    ->from('asset_features_values')
                    ->whereRaw('asset_features_values.asset_id = assets.id');
                $query_acreage->where('asset_features_values.feature_id', $feature_acreage);
                $query_acreage->whereIn('asset_features_values.variant_id', function ($query_variant) use ($feature_acreage, $params) {
                    $query_variant->select('id')
                        ->from('asset_features_variants')
                        ->where('asset_features_variants.feature_id', $feature_acreage)
                        ->where('asset_features_variants.status', 1)
                        ->where('asset_features_variants.is_deleted', 0);

                    if (isset($params['acreage_from'])) {
                        $query_variant->whereRaw('((asset_features_variants.`from` <= ? 
                        AND asset_features_variants.`to` >= ?) 
                        OR (asset_features_variants.`from` >= ?))', [$params['acreage_from'], $params['acreage_from'], $params['acreage_from']]);
                    }

                    if (isset($params['acreage_to'])) {
                        $query_variant->where('asset_features_variants.to', '<=', $params['acreage_to']);
                    }
                });
            });
        }

        if (isset($params['sort'])) {
            switch ($params['sort']) {
                case 'latest':
//                    $query->orderByRaw('ISNULL(assets.date_public), assets.date_public desc');
                    $query->orderBy('assets.id', 'desc');
                    break;
                case 'price-asc':
                case 'price-desc':
                    $feature_price = \App\Helpers\General::get_settings('feature_price_id');
                    $feature_price = $feature_price['value']??0;

                    $query->leftJoin('asset_features_values', function ($join) use ($feature_price) {
                        $join->on('asset_features_values.asset_id', '=', 'assets.id')
                            ->where('asset_features_values.feature_id', '=', $feature_price);
                    });
                    $query->leftJoin('asset_features_variants', function ($join) use ($feature_price) {
                        $join->on('asset_features_variants.id', '=', 'asset_features_values.variant_id')
                            ->where('asset_features_variants.feature_id', '=', $feature_price);
                    });

                    $query->orderByRaw('ISNULL(asset_features_variants.position), asset_features_variants.position '.($params['sort']=='price-asc'?'asc':'desc'));
                    break;
                case 'acreage-asc':
                case 'acreage-desc':
                    $feature_acreage = \App\Helpers\General::get_settings('feature_acreage_id');
                    $feature_acreage = $feature_acreage['value']??0;

                    $query->leftJoin('asset_features_values', function ($join) use ($feature_acreage) {
                        $join->on('asset_features_values.asset_id', '=', 'assets.id')
                            ->where('asset_features_values.feature_id', '=', $feature_acreage);
                    });
                    $query->leftJoin('asset_features_variants', function ($join) use ($feature_acreage) {
                        $join->on('asset_features_variants.id', '=', 'asset_features_values.variant_id')
                            ->where('asset_features_variants.feature_id', '=', $feature_acreage);
                    });

                    $query->orderByRaw('ISNULL(asset_features_variants.position), asset_features_variants.position '.($params['sort']=='acreage-asc'?'asc':'desc'));
                    break;
                default:
                    $query->orderBy('assets.position', $params['order']??'asc');
                    $query->orderBy('assets.id', 'desc');
                    break;
            }
        } else {
            $query->orderBy('assets.position', $params['order']??'asc');
            $query->orderBy('assets.id', 'desc');
        }
        $query->distinct();
        return $query->paginate($params['limit']??12);
    }

    public static function getProvince()
    {
        $data = Province::pluck('name', 'province_id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }

    public static function getAssetCategory()
    {
        $data = AssetCategory::pluck('name', 'id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }


    public static function getDistrict($idProvince)
    {
        $data = District::where('province_id', $idProvince)->pluck('name', 'district_id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }

    public static function getWard($id)
    {
        $data = Ward::where('district_id', $id)->pluck('name', 'ward_id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }

    public static function getAssetFeatureVariant($idFeature)
    {
        $data = AssetFeatureVariant::select('id', 'name')-> where('asset_features_variants.feature_id', $idFeature)->get();//->pluck('name','district_id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }
    public static function getStatusFilter()
    {
        return array(
            '1' => 'Đang hoạt động',
            '0' => 'Không hoạt động',
            '2' => 'Đã cho thuê',
        );
    }

    public function getOptionsType()
    {
        return array(
            'lease' => 'Cho thuê',
            'buy' => 'Cần thuê',
        );
    }
    public static function getAssetByCategory($id)
    {
        $data = Asset::select('id', 'name')-> where('assets.asset_category_id', $id)->get();//->pluck('name','district_id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }

    public static function getPrice($id)
    {
        $data = Asset::select('price')-> where('assets.id', $id)->get();//->pluck('name','district_id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }
    public static function getAsset()
    {
        $data = Asset::select('id', 'name')->pluck('name', 'id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }

    public function district()
    {
        return $this->hasOne('App\Models\District', 'district_id', 'district_id');
    }
    public function ward()
    {
        return $this->hasOne('App\Models\Ward', 'ward_id', 'ward_id');
    }
}
