<?php
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetFeatureValue extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'asset_features_values';

    public $timestamps = false;

    protected $fillable = ['feature_id', 'asset_id', 'variant_id'];

//    protected $hidden = ['parent_id', 'is_deleted'];
    public function variant()
    {
        return $this->hasOne(AssetFeatureVariant::class, 'id', 'variant_id');
    }
    public function feature()
    {
        return $this->hasOne(AssetFeature::class, 'id', 'feature_id');
    }
    public static function getListAll($filter)
    {
        $sql = self::select('asset_features.*');

        $sql->where('asset_features.is_deleted', 0);

        

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('asset_features.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (isset($filter['status'])) {
            $sql->where('asset_features.status', $filter['status']);
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
            ->orderBy($filter['sort'], $filter['order'])
            ->get()
            ->toArray();

        return ['total' => $total, 'data' => $data];
    }

    public static function getParentOptions()
    {
        $data = ProductCategory::select('id', 'name')->pluck('name', 'id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }

    public static function getCategoryOptions()
    {
        $data = ProductCategory::select('id', 'name')->pluck('name', 'id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }

    public static function getAssetFeature()
    {
        $data = AssetFeature::select('id', 'name')->pluck('name', 'id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }

    public static function getCategoryById($id)
    {
        $data = ProductCategory::select('product_categories.*', 'manufacturers.name as manufacturer_name')
            ->leftJoin('manufacturers', 'manufacturers.id', '=', 'product_categories.manufacturer_id')
            ->where('product_categories.id', $id)
            ->where('product_categories.is_deleted', 0)->first();

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }

    public static function getCategoryBymanufacturer($manufacturer_id)
    {
        $data = ProductCategory::select(
            'product_categories.id',
            'product_categories.name',
            'product_categories.image_url',
            'product_categories.image',
            'manufacturers.name as manufacturer_name'
        )
            ->leftJoin('manufacturers', 'manufacturers.id', '=', 'product_categories.manufacturer_id')
            ->where('product_categories.manufacturer_id', $manufacturer_id)
            ->where('product_categories.is_deleted', 0)
            ->orderBy('product_categories.order', 'asc')->get();
        if (!empty($data)) {
            return $data->toArray();
        }
        return  array();
    }

    public static function ajaxGetCategoryBymanufacturer($manufacturer_id)
    {
        $data = ProductCategory::select('id', 'name')-> where('product_categories.manufacturer_id', $manufacturer_id)->pluck('name', 'id');

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
        );
    }
}
