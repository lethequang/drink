<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'code', 'description', 'short_description', 'category_id', 'manufacturer_id', 'order',
        'image', 'image_url', 'price', 'amount','is_home', 'created_at', 'updated_at', 'is_deleted'];

//    protected $hidden = ['deleted_at', 'is_deleted'];

    public static function getListAll($filter){

        $sql = self::select('products.*', 'manufacturers.name as manufacturer_name', 'product_categories.name as category_name')
                        ->leftJoin('manufacturers', 'manufacturers.id', '=', 'products.manufacturer_id')
                        ->leftJoin('product_categories', 'product_categories.id', '=', 'products.category_id');

        $sql->where('products.is_deleted', '!=', -1);

        if (!empty($keyword = $filter['search'])) {
            $sql->where(function ($query) use ($keyword) {
                $query->where('products.name', 'LIKE', '%' . $keyword . '%')
                      ->orWhere('manufacturers.name', 'LIKE', '%' . $keyword . '%')
                      ->orWhere('product_categories.name', 'LIKE', '%' . $keyword . '%');
            });
        }

        if(!empty($filter['code'])){
            $sql->where(['products.code' => $filter['code']]);
        }

        if (!empty($status = $filter['status'])) {
            if ($status == 'is_active') {
                $sql->where('products.is_deleted', 0);
            } else {
                $sql->where('products.is_deleted', 1);
            }
        }

        if (!empty($status_home = $filter['is_home'])) {
            if($status_home == 'not_home'){
                $sql->where('products.is_home', 0);
            }else{
                $sql->where('products.is_home', 1);
            }
        }

        $total = $sql->count();

        $data = $sql->skip($filter['offset'])
            ->take($filter['limit'])
            ->orderBy($filter['sort'], $filter['order'])
            ->get()
            ->toArray();

        return ['total' => $total, 'data' => $data];
    }

    public static function getParentOptions(){

        $data = ProductCategory::select('id','name')->pluck('name','id');

        if(!empty($data))
        {
            return $data->toArray();
        }

        return  array();
    }

    public static function getHomeProducts() {

        $objects = Product::select('id', 'name', 'image')
            ->where('is_deleted', 0)
            ->where('is_home', 1)
            ->orderBy('updated_at', 'desc');

        return $objects->get()->toArray();
    }

    public static function getProductsByCate($category_id, $limit){
        $data = Product::select('products.id','products.name', 'products.image', 'product_categories.name as category_name')
                            ->leftJoin('product_categories', 'product_categories.id', '=', 'products.category_id')
                            -> where('products.category_id', $category_id)
                            -> where('products.is_deleted', 0)
                            ->orderBy('products.order', 'desc');

        return $data->paginate($limit)->toArray();
    }

    public static function getProductById($id){

        $data = [];

        $product = Product::select('products.*', 'manufacturers.name as manufacturer_name', 'product_categories.name as category_name')
                            ->leftJoin('manufacturers', 'manufacturers.id', '=', 'products.manufacturer_id')
                            ->leftJoin('product_categories', 'product_categories.id', '=', 'products.category_id')
                            ->where('products.id', $id)->first();

        if(!empty($product))
        {
            $product = $product->toArray();
            $data['product'] = $product;

            $data['images'] = [];
            $images = ProductImage::select('image')
                        ->where('product_id', $id)->get();

            if(count($images))
            {
                $data['images'][] = array('image' => $product['image']);
                foreach ($images as $image)
                {
                    $data['images'][] = $image->toArray();
                }
            }
            return $data;
        }

        return  array();
    }

    public static function getProductsSameCode($code, $except_ids=[]) {
        $query = Product::select('*')
            ->where('code', $code)
            ->where('is_deleted', 0);

        if($except_ids) {
            if (is_array($except_ids)) {
                $query->whereNotIn('id', $except_ids);
            } else {
                $query->where('id', '!=', $except_ids);
            }
        }

        $query->orderBy('products.order', 'asc');

        return $query->get()->toArray();
    }

    public static function getProductsSameCategory($category_id, $except_ids=[]) {
        $query = Product::select('*')
            ->where('category_id', $category_id)
            ->where('is_deleted', 0);

        if (is_array($except_ids)) {
            $query->whereNotIn('id', $except_ids);
        } else {
            $query->where('id', '!=', $except_ids);
        }

        $query->orderBy('products.order', 'asc');

        return $query->get()->toArray();
    }

    public static function getAllProducts(){

        $data = [];

        $products = Product::select('products.*', 'product_categories.name as category_name')
                            ->leftJoin('product_categories', 'product_categories.id', '=', 'products.category_id')
                            ->where('products.amount', '>', 0)
                            ->orderBy('products.order', 'asc')
                            ->get();

        if(count($products))
        {
            foreach ($products as $item)
            {
                $data[] = $item->toArray();
            }
        }
        return $data;
    }

    public static function getSearchProducts($params) {

        $objects = Product::select('products.*', 'product_categories.name as category_name')
            ->leftJoin('articles', 'articles.product_code', '=', 'products.code')
            ->leftJoin('product_categories', 'product_categories.id', '=', 'articles.category_id')
            ->where('products.is_deleted', 0);

        if (isset($params['search'])) {
            $keyword = $params['search'];
            $objects->where(function ($query) use ($keyword) {
                $query->where('products.name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('product_categories.name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('products.description', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('products.short_description', 'LIKE', '%' . $keyword . '%');
            });
        }

        $objects->orderBy($params['sort']??'products.order', $params['order']??'asc');

        return $objects->paginate($params['limit']??12)->toArray();
    }

    public static function getStatusHomeFilter() {
        return array(
            'is_home' => 'Hiển thị Home',
            'not_home' => 'Không hiển thị Home',
        );
    }

    public static function getStatusFilter() {
        return array(
            'is_active' => 'Đang hoạt động',
            'not_active' => 'Không hoạt động',
        );
    }

    public static function getCategoryFilter() {
        $data = ProductCategory::select('id','name')->pluck('name','id');

        if(!empty($data))
        {
            return $data->toArray();
        }

        return  array();
    }

    public static function getManufacturerFilter() {
        $data = Manufacturer::select('id','name')->pluck('name','id');

        if(!empty($data))
        {
            return $data->toArray();
        }

        return  array();
    }
}
?>
