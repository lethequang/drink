<?php


namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleCrawler;
use App\Models\ArticleCategory;
use App\Models\Crawler;
use App\Models\ProductCategory;
use App\Models\ArticleImage;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Helpers\General;
use Log;
use Session;
use DB;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class ArticleController extends Controller
{
    private $_data = array();
    private $_model;

    /* *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_data['title'] = 'Bài viết';
        $this->_data['controllerName'] = 'article';
        $this->_model = new Article();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->_data['status'] = ['' => ''] + $this->_model->getStatusFilter();

        $this->_data['article_categories'] = ['' => ''] + $this->_model->getArticleCategory();


        return view("admin.{$this->_data['controllerName']}.index", $this->_data);
    }

    public function listCraw()
    {
        $this->_data['status'] = ['' => ''] + $this->_model->getStatusFilter();

        $this->_data['article_categories'] = ['' => ''] + $this->_model->getArticleCategory();

        return view("admin.{$this->_data['controllerName']}.list_craw", $this->_data);
    }



    public function showListCraw(Request $request)
    {
        $filter = [
            'offset' => $request->input('offset', 0),
            'limit' => $request->input('limit', 10),
            'sort' => $request->input('sort', 'articles_crawler.id'),
            'order' => $request->input('order', 'asc'),
            'search' => $request->input('search', ''),
            'status' => $request->input('status', 1),
            'category_id' => $request->input('category_id', ''),
        ];

        $data = ArticleCrawler::getListAll($filter);

        return response()->json([
            'total' => $data['total'],
            'rows' => $data['data'],
        ]);
    }


    public function show(Request $request)
    {
        $filter = [
            'offset' => $request->input('offset', 0),
            'limit' => $request->input('limit', 10),
            'sort' => $request->input('sort', 'articles.id'),
            'order' => $request->input('order', 'asc'),
            'search' => $request->input('search', ''),
            'status' => $request->input('status', 1),
            'category_id' => $request->input('category_id', ''),
        ];

        $data = $this->_model->getListAll($filter);
        return response()->json([
            'total' => $data['total'],
            'rows' => $data['data'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->_data['orderOptions'] = General::getOrderOptions();

        $article_categories = array('' => '') + ArticleCategory::getCategoryArticles();
        $this->_data['article_categories'] = $article_categories;


        return view("admin.{$this->_data['controllerName']}.create", $this->_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $data = $request->all();

        unset($data['_token']);

        if (empty($data['image_url']) && strpos($data['image'], 'http')===false) {
            $data['image_url'] = config('app.url');
        }

        $object = $this->_model->create($data);

        if ($object) {
            if ($object && isset($data['product_images'])) {
                $this->store_product_images($object->id, $data['product_images']);
            }

            if ($request->ajax() || $request->wantsJson()) {
                $request->session()->flash('error', 0);
                $request->session()->flash('message', 'Thêm mới ' . $this->_data['title'] . ' thành công');

                return response()->json([
                    'rs' => 1,
                    'msg' => 'Thêm mới ' . $this->_data['title'] . ' thành công',
                    'act' => 'add',
                    'link_edit' => route('article.edit', ['id' => $object->id])
                ]);
            }

            return redirect()->route("{$this->_data['controllerName']}.index");
        }

        if ($request->ajax() || $request->wantsJson()) {
            $request->session()->flash('error', 1);
            $request->session()->flash('message', 'Thêm mới ' . $this->_data['title'] . ' không thành công');

            return response()->json([
                'rs' => 0,
                'msg' => 'Thêm mới ' . $this->_data['title'] . ' không thành công',
                'act' => 'add'
            ]);
        }

        return redirect("/admin/{$this->_data['controllerName']}/add");
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $object = $this->_model->find($id)->toArray();
        $this->_data['id'] = $id;
        $this->_data['object'] = $object;
        $this->_data['orderOptions'] = General::getOrderOptions();
        $article_categories = array('' => '') + ArticleCategory::getCategoryArticles();
        $this->_data['article_categories'] = $article_categories;

        $this->_data['product_images'] = ArticleImage::select(\DB::Raw('CONCAT(image_url, image) as image'), 'id')->where('article_id', $id)->pluck('image', 'id');

        return view("admin.{$this->_data['controllerName']}.create", $this->_data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $object = $this->_model->find($id);

        if (!$object) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'rs' => 0,
                    'msg' => 'Lỗi không tồn tại',
                    'act' => 'edit'
                ]);
            }

            return redirect()->route("{$this->_data['controllerName']}.index");
        }

        $data = $request->all();

        if (empty($data['image_url']) && strpos($data['image'], 'http')===false) {
            $data['image_url'] = config('app.url');
        }

        unset($data['_token']);


        $rs = $object->update($data);

        if ($rs && isset($data['product_images'])) {
            $this->store_product_images($id, $data['product_images']);
        }

        if ($request->ajax() || $request->wantsJson()) {
            $request->session()->flash('error', 0);
            $request->session()->flash('message', 'Chỉnh sửa ' . $this->_data['title'] . ' thành công');

            return response()->json([
                'rs' => 1,
                'msg' => 'Chỉnh sửa ' . $this->_data['title'] . ' thành công',
                'act' => 'edit',
                'link_edit' => route('article.edit', ['id' => $object->id])
            ]);
        }

        return redirect()->route("{$this->_data['controllerName']}.index");
    }

    public function store_product_images($article_id, $product_images)
    {
        if (isset($product_images['delete'])) {
            ArticleImage::where('article_id', $article_id)
                            ->whereIn('id', $product_images['delete'])->delete();
            unset($product_images['delete']);
        }

        foreach ($product_images as $item) {
            if ($item['id']) {
                continue;
            }

            $item['image'] = General::move_image('articles/'.$article_id, $item['image']);

            if ($item['image']) {
                ArticleImage::create([
                    'article_id' => $article_id,
                    'image' => $item['image'],
                    'image_url' => config('app.url')
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $object = $this->_model->find($id);

        if (!$object || !$id) {
            return response()->json([
                'rs' => 0,
                'msg' => 'Xóa ' . $this->_data['title'] . ' không thành công',
            ]);
        }

        $object->is_deleted = 0;

        $object->save();

        return response()->json([
            'rs' => 1,
            'msg' => 'Xóa ' . $this->_data['title'] . ' thành công',
        ]);
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function ajaxActive(Request $request)
    {
        $ids = $request->all()['ids'];

        if (!empty($ids)) {
            foreach ($ids as $id) {
                $object = $this->_model->find($id);
                $object->status = 1;
                $object->save();
            }
            return response()->json([
                'rs' => 1,
                'msg' => 'Kích hoạt ' . $this->_data['title'] . ' thành công',
                'act' => 'active'
            ]);
        }

        return response()->json([
            'rs' => 1,
            'msg' => 'Kích hoạt ' . $this->_data['title'] . ' không thành công',
            'act' => 'active'
        ]);
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function ajaxInactive(Request $request)
    {
        $ids = $request->all()['ids'];

        if (!empty($ids)) {
            foreach ($ids as $id) {
                $object = $this->_model->find($id);
                $object->status = 0;
                $object->save();
            }
            return response()->json([
                'rs' => 1,
                'msg' => 'Ngừng kích hoạt ' . $this->_data['title'] . ' thành công',
                'act' => 'inactive'
            ]);
        }

        return response()->json([
            'rs' => 1,
            'msg' => 'Ngừng kích hoạt ' . $this->_data['title'] . ' không thành công',
            'act' => 'inactive'
        ]);
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function ajaxDelete(Request $request)
    {
        $ids = $request->all()['ids'];

        if (!empty($ids)) {
            foreach ($ids as $id) {
                $object = $this->_model->find($id);
                $object->is_deleted = 1;
                $object->save();
            }
            return response()->json([
                'rs' => 1,
                'msg' => 'Xóa ' . $this->_data['title'] . ' thành công',
                'act' => 'delete'
            ]);
        }

        return response()->json([
            'rs' => 1,
            'msg' => 'Xóa ' . $this->_data['title'] . ' không thành công',
            'act' => 'delete'
        ]);
    }

    public function ajaxGetDistrictByProvince($province_id)
    {
        $res = [];

        if (!empty($province_id)) {
            $res = General::getDistrictOptionsByProvince($province_id);
        }

        return response()->json($res);
    }

    public function ajaxGetWardByDistrict($district_id)
    {
        $res = [];

        if (!empty($district_id)) {
            $res = General::getWardOptionsByDistrict($district_id);
        }

        return response()->json($res);
    }

    public function getCraw($id)
    {
        $object = Crawler::find($id);

        $this->_data['id'] = $id;
        $this->_data['object'] = $object;


        $type = array('' => '') + Crawler::getOptionsType();
        $this->_data['type'] = $type;
        return view("admin.{$this->_data['controllerName']}.craw", $this->_data);
    }

    public function postCraw(Request $request)
    {
        $link_tag = $request->input('link_tag');
        $post_tag = $request->input('post_tag');
        $url_tag = $request->input('url_tag');
        $avatar_tag = $request->input('avatar_tag');
        $title_tag = $request->input('title_tag');
        $description_tag = $request->input('description_tag');
        $content_tag = $request->input('content_tag');
        $type = $request->input('type');


        $url = $link_tag;

        $client = new Client();
        $crawler = $client->request('GET', $url);
        $goutteClient = new Client();
        $guzzleClient = new GuzzleClient(array(
            'timeout' => 60,
        ));
        $goutteClient->setClient($guzzleClient);
//        $link = $crawler->selectLink('BẤT ĐỘNG SẢN')->link();
//
//        $crawler = $client->click($link);

        $link = array();
        $uri = $url_tag;

        $crawler->filter($avatar_tag)->each(function ($node)use (&$image) {
            $image[] =  $node->attr('src');
        });

        $crawler->filter($post_tag)->each(function ($node) use (&$link, $uri) {
            if (strlen(strstr( $node->attr('href'), $uri)) > 0) {
                $link[] = $node->attr('href');
            }
            else{
                $link[] = $uri . $node->attr('href');
            }

        });
//dd($image);
        $elements = array(
            // css selectors to target
            "selectors" => array(
               $title_tag,
               $description_tag,
               $content_tag
           ),
            //elements to extract (corresponding to the above css selectors)
            "types" => array(
                "_text", "_text", "_text"
            ),
            // how many times per page?
            "count" => 1,
        );

        foreach ($link as $k => $v) {
            $client = new Client();
            $crawler = $client->request('GET', $v);
            for ($i = 0; $i < $elements["count"]; $i++) {        //repetitions per url
                foreach ($elements["selectors"] as $key => $value) {        //loop through each selector
                    $count = $crawler->filter($value)->count();
                    if ($count > 0) {        //check that the element exists on the page
                        $index = $crawler->filter($value)->eq($i)->extract($elements["types"][$key]);
                        $arr[$i][$key] = array_shift($index);
                    }
                }
                // var_dump($arr);
            }
//             dd($arr);
            foreach ($arr as $key => $item) {
                $posts[] = [
                    "avatar" => isset($image[$key]) ? $image[$key] : "",
                    "title" => $item[0],
                    "description" => $item[1],
                    "content" => $item[2],
                    "source_detail" => $v,
                ];
            }
        }
//dd($posts);
        foreach ($posts as $post) {
            $insert = DB::table('articles_crawler')->insert([
                'name' => trim($post["title"]),
                'description' => trim($post["description"]),
                'content' => trim($post["content"]),
                'article_category_id' => $type,
                'image' => $post["avatar"],
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'source' => $uri,
                'source_detail' => $post['source_detail'],
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            $request->session()->flash('error', 0);
            $request->session()->flash('message', 'Lấy ' . $this->_data['title'] . ' thành công');

            return response()->json([
                'rs' => 1,
                'msg' => 'Lấy ' . $this->_data['title'] . ' thành công',
                'act' => 'edit',
                'link_edit' => route('article.lits.craw')
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            $request->session()->flash('error', 1);
            $request->session()->flash('message', 'Lấy ' . $this->_data['title'] . ' không thành công');

            return response()->json([
                'rs' => 0,
                'msg' => 'Lấy ' . $this->_data['title'] . ' không thành công',
                'act' => 'add'
            ]);
        }


    }

}
