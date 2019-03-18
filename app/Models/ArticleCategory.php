<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_categories';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'created_at', 'updated_at', 'is_deleted', 'description', 'position', 'status', 'created_by'];

//    protected $hidden = ['deleted_at', 'is_deleted'];

    public static function getListAll($filter){

        $sql = self::select('manufacturers.*');
//        $sql->where('manufacturers.is_deleted', 0);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('manufacturers.name', 'LIKE', '%' . $keyword . '%');
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

    public static function getManufacturerOptions(){

        $data = Manufacturer::select('id','name')->pluck('name','id');

        if(!empty($data))
        {
            return $data->toArray();
        }

        return  array();
    }

    public static function getManufacturerById($id){

        $data = Manufacturer::select('*')->where('id', $id)->first();

        if(!empty($data))
        {
            return $data->toArray();
        }

        return  array();
    }

    public static   function getCategoryArticles(){
        $data = ArticleCategory::select('id','name')->pluck('name','id');

        if(!empty($data))
        {
            return $data->toArray();
        }

        return  array();
    }
}
?>
