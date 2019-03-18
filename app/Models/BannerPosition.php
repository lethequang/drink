<?php
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerPosition extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'banner_positions';

    protected $primaryKey = 'id';

    protected $fillable = ['banner_positions.*'];

//    protected $hidden = ['deleted_at', 'is_deleted'];

    public static function getListAll($filter)
    {
        $sql = self::select('banner_positions.*');

             if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('banner_positions.name', 'LIKE', '%' . $keyword . '%');
            });
        }


        if (isset($filter['status'])) {
            $sql->where('banner_positions.status', $filter['status']);
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

    public static function getBannerPosition()
    {
        $data = BannerPositions::select('id', 'name')->pluck('name', 'id');

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

    public function path()
    {
        $slug = str_slug($this->name, '-');
        return $slug . '-n' .  $this->id . '.html';
    }
}
