<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'partners';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'image', 'link', 'position', 'image_url', 'created_at', 'updated_at', 'is_deleted'];

//    protected $hidden = ['deleted_at', 'is_deleted'];

    public static function getListAll($filter){

        $sql = self::select('partners.*');
//        $sql->where('partners.is_deleted', 0);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('partners.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
            ->orderBy($filter['sort'], $filter['order'])
            ->get()
            ->toArray();

        return ['total' => $total, 'data' => $data];
    }
}
?>