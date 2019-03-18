<?php
 namespace App\Models;
use App\Model\BannerPositions;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'banners';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'ordering', 'url', 'article_category_id', 'manufacturer_id', 'position_id',
        'image_location', 'image_url', 'created_at', 'updated_at', 'is_deleted', 'status', 'page', 'user_created', 'user_modified'];

//    protected $hidden = ['deleted_at', 'is_deleted'];

    public static function getListAll($filter)
    {
        $sql = self::select('banners.*', 'banner_positions.description as banner_positions_name' )
            ->leftJoin('banner_positions', 'banner_positions.id', '=', 'banners.position_id');

        $sql->where('banners.is_deleted', 0);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('banners.name', 'LIKE', '%' . $keyword . '%');
            });
        }
        if (!empty($filter['banner_position'])) {
            $sql->where('banners.position_id' , $filter['banner_position']);
        }

        if (isset($filter['status'])) {
            $sql->where('banners.status', $filter['status']);
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
            ->orderBy($filter['sort'], $filter['order'])
            ->get()
            ->toArray();

        return ['total' => $total, 'data' => $data];
    }

    public static function getBannerPosition()
    {
        $data = BannerPosition::select('id', 'description')->pluck('description', 'id');

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

    public static function getBannersByPage($page='home')
    {
        $query = self::select('banners.*', 'banner_positions.position')
            ->join('banner_positions', 'banner_positions.id', '=', 'banners.position_id')
            ->where('banners.is_deleted', 0)
            ->where('banners.status', 1);

        if ($page) {
            $query->where('banners.page', $page);
        }

        $query->orderBy('banners.ordering', 'asc');
        $query->orderBy('banners.id', 'desc');

        $objects = $query->get()->toArray();
        $rs = [];
        foreach ($objects as $item) {
            $rs[$item['position']][] = $item;
        }

        return $rs;
    }
}
