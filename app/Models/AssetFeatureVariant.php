<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  App\Models\AssetFeature;

class AssetFeatureVariant extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'asset_features_variants';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description', 'feature_id', 'from', 'to', 'price',
        'position', 'status', 'created_at', 'updated_at', 'is_deleted'];

//    protected $hidden = ['parent_id', 'is_deleted'];

    public static function getListAll($filter)
    {
        $sql = self::select('asset_features_variants.*', 'asset_features.name as feature_name')
                        ->leftJoin('asset_features', 'asset_features.id', '=', 'asset_features_variants.feature_id');
        $sql->where('asset_features_variants.is_deleted', 0);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('asset_features_variants.name', 'LIKE', '%' . $keyword . '%')
                      ->orWhere('asset_features.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (isset($filter['status'])) {
            $sql->where('asset_features_variants.status', $filter['status']);
        }

        if (isset($filter['assetFeature'])) {
            $sql->where('asset_features_variants.feature_id', $filter['assetFeature']);
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
            ->orderBy($filter['sort'], $filter['order'])
            ->get()
            ->toArray();

        return ['total' => $total, 'data' => $data];
    }

    public static function getVariantsOptions($feature_id)
    {
        $data = self::select('id', 'name')
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->where('feature_id', $feature_id)
            ->pluck('name', 'id');

        return $data->toArray();
    }

    public static function getAssetFeature()
    {
        $data = AssetFeature::select('id', 'name')->where('is_deleted', 0)->pluck('name', 'id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return array();
    }



    public static function getStatusFilter()
    {
        return array(
            '1' => 'Đang hoạt động',
            '0' => 'Không hoạt động',
        );
    }
    public function assetFeature()
    {
        return $this->belongsTo('App\Models\AssetFeatureVariant', 'feature_id', 'asset_features.id');
    }
}
