<?php
 namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Article extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description', 'content', 'article_category_id', 'manufacturer_id', 'position',
        'image', 'image_url', 'created_at', 'updated_at', 'is_deleted', 'status', 'is_hot', 'is_common'];

//    protected $hidden = ['deleted_at', 'is_deleted'];

    public static function getHomeArticles()
    {
        $objects = self::select('id', 'name', 'image', 'image_url')
            ->where('is_deleted', 0)
            ->orderBy('order', 'asc')
            ->limit(12);

        return $objects->get()->toArray();
    }

    public static function getListAll($filter)
    {
        $sql = self::select('articles.*', 'article_categories.name as category_name')
                        ->leftJoin('article_categories', 'article_categories.id', '=', 'articles.article_category_id');


        $sql->where('articles.is_deleted', 0);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('articles.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (!empty($filter['category_id'])) {
            $sql->where(['articles.article_category_id' => $filter['category_id']]);
        }

        if (isset($filter['status'])) {
            $sql->where('articles.status', $filter['status']);
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
            ->orderBy($filter['sort'], $filter['order'])
            ->get()
            ->toArray();

        return ['total' => $total, 'data' => $data];
    }
    public static function getListAllCraw($filter)
    {
        $sql = DB::table('articles_crawler')->select('articles_crawler.*', 'article_categories.name as category_name')
            ->leftJoin('article_categories', 'article_categories.id', '=', 'articles_crawler.article_category_id');


        $sql->where('articles_crawler.is_deleted', 0);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('articles_crawler.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        if (!empty($filter['category_id'])) {
            $sql->where(['articles_crawler.article_category_id' => $filter['category_id']]);
        }

        if (isset($filter['status'])) {
            $sql->where('articles_crawler.status', $filter['status']);
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

    public static function getArticlesByCate($category_id, $limit)
    {
        $data = Article::select('articles.id', 'articles.name', 'articles.image', 'product_categories.name as category_name')
                            ->leftJoin('product_categories', 'product_categories.id', '=', 'articles.category_id')
                            ->where('articles.category_id', $category_id)
                            ->where('articles.is_deleted', 0)
                            ->where('articles.status', 1)
                            ->orderBy('articles.order', 'asc');

        return $data->paginate($limit)->toArray();
    }

    public static function getArticleById($id)
    {
        $data = [];

        $product = Article::select('articles.*', 'manufacturers.name as manufacturer_name', 'product_categories.name as category_name')
                            ->leftJoin('manufacturers', 'manufacturers.id', '=', 'articles.manufacturer_id')
                            ->leftJoin('product_categories', 'product_categories.id', '=', 'articles.category_id')
                            ->where('articles.id', $id)->first();

        return $product ? $product->toArray() : [];
    }


    public static function getArticlesSameCategory($category_id, $except_ids=[])
    {
        $query = Article::select('*')
            ->where('category_id', $category_id)
            ->where('is_deleted', 0);

        if ($except_ids) {
            if (is_array($except_ids)) {
                $query->whereNotIn('id', $except_ids);
            } else {
                $query->where('id', '!=', $except_ids);
            }
        }

        $query->orderBy('articles.order', 'asc');

        return $query->get()->toArray();
    }

    public static function getAllProducts()
    {
        $data = [];

        $products = Article::select('articles.*', 'product_categories.name as category_name')
                            ->leftJoin('product_categories', 'product_categories.id', '=', 'articles.category_id')
                            ->where('articles.amount', '>', 0)
                            ->orderBy('articles.order', 'asc')
                            ->get();

        if (count($products)) {
            foreach ($products as $item) {
                $data[] = $item->toArray();
            }
        }
        return $data;
    }

    public static function getSearchArticles($params)
    {
        $objects = Article::select('articles.*', 'product_categories.name as category_name')
            ->leftJoin('product_categories', 'product_categories.id', '=', 'articles.category_id')
            ->where('articles.is_deleted', 0);

        if (isset($params['search'])) {
            $keyword = $params['search'];
            $objects->where(function ($query) use ($keyword) {
                $query->where('articles.name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('product_categories.name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('articles.description', 'LIKE', '%' . $keyword . '%');
                $query->orWhere(function ($query_products) use ($keyword) {
                    $query_products->whereExists(function ($query_products_exists) use ($keyword) {
                        $query_products_exists->select(\DB::raw(1))
                            ->from('products')
                            ->orWhere('products.name', 'LIKE', '%' . $keyword . '%')
//                            ->orWhere('products.short_description', 'LIKE', '%' . $keyword . '%')
//                            ->orWhere('products.description', 'LIKE', '%' . $keyword . '%')
                            ->whereRaw('products.code = articles.product_code');
                    });
                });
            });
        }

        $objects->orderBy($params['sort']??'articles.order', $params['order']??'asc');

        return $objects->paginate($params['limit']??12)->toArray();
    }

    public static function getStatusFilter()
    {
        return array(
            '1' => 'Đang hoạt động',
            '0' => 'Không hoạt động',
        );
    }

    public static function getCategoryFilter()
    {
        $data = ProductCategory::select('id', 'name')->pluck('name', 'id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }

    public static function getArticleCategory()
    {
        $data = ArticleCategory::select('id', 'name')->pluck('name', 'id');

        if (!empty($data)) {
            return $data->toArray();
        }

        return  array();
    }


    public function path()
    {
        $slug = str_slug($this->name, '-');
        return $slug . '-n' .  $this->id . '.html';
    }
}
