<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlideShow extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'slides';

    protected $primaryKey = 'id';

    protected $fillable = ['title', 'description', 'image', 'image_url', 'link', 'created_at', 'updated_at', 'is_deleted'];

//    protected $hidden = ['deleted_at', 'is_deleted'];

    public static function getListAll($filter){

        $sql = self::select('slides.*');
//        $sql->where('slides.is_deleted', 0);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('slides.name', 'LIKE', '%' . $keyword . '%');
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

    public static function getSlideShows()
    {
        $objects = SlideShow::where('is_deleted',0)->get();
        $data = [];
        if(count($objects))
        {
            foreach ($objects as $item)
            {
                $data[] = $item->toArray();
            }
        }
        return $data;
    }
}
?>