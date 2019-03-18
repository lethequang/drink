<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'asset_categories';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'type', 'description', 'is_deleted', ];

//    protected $hidden = ['deleted_at', 'is_deleted'];

    public static function getListAll($filter)
    {
        $sql = self::select('asset_categories.*');
//        $sql->where('manufacturers.is_deleted', 0);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('asset_categories.name', 'LIKE', '%' . $keyword . '%');
            });
        }
        if (isset($filter['status'])) {
            $sql->where('asset_categories.status', $filter['status']);
        }
        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
            ->orderBy($filter['sort'], $filter['order'])
            ->get()
            ->toArray();

        return ['total' => $total, 'data' => $data];
    }

    public static function getCategory()
    {
        $data = AssetCategory::select('id', 'name')->pluck('name', 'id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }

    public function province()
    {
        return $this->belongsTo('App\Models\Province', 'province_id');
    }

    public static function getAssetCategories()
    {
        $objects = self::select('id', 'name', 'type')
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->orderBy('position', 'asc')
            ->get();

        $rs = [];
        foreach ($objects as $item) {
            $rs[$item['type']][$item['id']] = $item['name'];
        }

        return $rs;
    }

    public static function getAssetCategory($id)
    {
        $data = AssetCategory::select('id', 'name')-> where('asset_categories.type', $id)->get();//->pluck('name','district_id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }

    public static function getTypeAssetCategory()
    {
        $data = Asset::pluck('type', 'id');

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
    public static function getType()
    {
        return array(
            'lease' => 'Cho thuê',
            'buy' => 'Cần thuê',
        );
    }
}
