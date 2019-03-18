<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Crawler extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crawlers';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'link_tag', 'post_tag', 'url_tag', 'avatar_tag', 'title_tag',
        'description_tag', 'content_tag', 'created_at', 'updated_at', 'is_deleted', 'status', 'type'
    ];

//    protected $hidden = ['deleted_at', 'is_deleted'];

    public static function getListAll($filter)
    {
        $sql = self::select('crawlers.*', 'article_categories.name as category_name')
            ->leftJoin('article_categories', 'article_categories.id', '=', 'crawlers.type');
        $sql->where('crawlers.is_deleted', 0);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('crawlers.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (isset($filter['status'])) {
            $sql->where('crawlers.status', $filter['status']);
        }
        if (!empty($filter['category_id'])) {
            $sql->where(['crawlers.type' => $filter['category_id']]);
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
            ->orderBy($filter['sort'], $filter['order'])
            ->get()
            ->toArray();

        return ['total' => $total, 'data' => $data];
    }


    public static function getStatusFilter()
    {
        return array(
            '1' => 'Đang hoạt động',
            '0' => 'Không hoạt động',
        );
    }

    public static function getCrawler()
    {
        $data = Crawler::select('id', 'url_tag')->pluck('url_tag', 'id');

        if (!empty($data)) {
            return $data->toArray();
        }
        return array();
    }

    public static function getOptionsType()
    {
        $data = ArticleCategory::pluck('name', 'id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return array();
    }

    public static function getArticleCategory()
    {
        $data = ArticleCategory::select('id', 'name')->pluck('name', 'id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return array();
    }

}
