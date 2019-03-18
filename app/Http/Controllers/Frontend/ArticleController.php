<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\Manufacturer;
use App\Models\ProductCategory;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $data = []; // the information we send to the view

    public function index(Request $request)
    {
        $articles = Article::select('*')
            ->where(['status' => 1, 'article_category_id' => 1, 'is_deleted' => 0]);
        $kw = $request->input('kw', '');
        if ($kw) {
            $articles->where('articles.name', 'LIKE', '%' . $kw . '%');
        }
        $articles = $articles->orderBy('id', 'DESC')->paginate(5);

        $ishots = Article::where(['is_hot' => 1, 'status' => 1, 'article_category_id' => 1, 'is_deleted' => 0])->latest()->take(5)->get();
        $iscommons = Article::where(['is_common' => 1, 'status' => 1, 'article_category_id' => 1, 'is_deleted' => 0])->latest()->take(5)->get();

        $this->data['articles'] = $articles;
        $this->data['ishots'] = $ishots;
        $this->data['iscommons'] = $iscommons;

        return view('frontend.article.index', $this->data);
    }

    public function fengshui(Request $request)
    {
        $ishots = Article::where(['is_hot' => 1, 'status' => 1, 'article_category_id' => 1, 'is_deleted' => 0])->latest()->take(5)->get();
        $iscommons = Article::where(['is_common' => 1, 'status' => 1, 'article_category_id' => 2, 'is_deleted' => 0])->latest()->take(5)->get();

        $fengshuis = Article::select('*')
            ->where(['status' => 1, 'article_category_id' => 2, 'is_deleted' => 0]);
        $kw = $request->input('kw', '');
        if ($kw) {
            $fengshuis->where('articles.name', 'LIKE', '%' . $kw . '%');
        }
        $fengshuis = $fengshuis->orderBy('id', 'DESC')->paginate(2);

        $this->data['ishots'] = $ishots;
        $this->data['iscommons'] = $iscommons;
        $this->data['fengshuis'] = $fengshuis;

        return view('frontend.article.fengshui', $this->data);
    }

    public function show(Request $request, $slug, $id)
    {
        $articles = Article::findOrFail($id);
        $ishots = Article::where(['is_hot' => 1, 'status' => 1, 'article_category_id' => 1, 'is_deleted' => 0])->latest()->take(5)->get();
        $iscommons = Article::where(['is_common' => 1, 'status' => 1, 'article_category_id' => 1, 'is_deleted' => 0])->latest()->take(5)->get();
        $articlePrevious = Article::where('id', '<', $id)
                                    ->orderBy('id', 'desc')
                                    ->first();
        $articleNext = Article::where('id', '>', $id)
                                   ->orderBy('id', 'asc')
                                    ->first();
        $postRandom = Article::inRandomOrder()->where('id', '!=', $id)
                                        ->where(['status' => 1, 'article_category_id' => 1, 'is_deleted' => 0])
                                        ->limit(2)
                                        ->get();
        $this->data['ishots'] = $ishots;
        $this->data['articles'] = $articles;
        $this->data['iscommons'] = $iscommons;
        $this->data['articlePrevious'] = $articlePrevious;
        $this->data['articleNext'] = $articleNext;
        $this->data['postRandom'] = $postRandom;


        return view('frontend.article.show', $this->data);
    }
    public function showFengshui(Request $request, $slug, $id)
    {
        $articles = Article::findOrFail($id);
        $ishots = Article::where(['is_hot' => 1, 'status' => 1, 'article_category_id' => 2, 'is_deleted' => 0])->latest()->take(5)->get();
        $iscommons = Article::where(['is_common' => 1, 'status' => 1, 'article_category_id' => 2, 'is_deleted' => 0])->latest()->take(5)->get();

        $articlePrevious = Article::where('id', '<', $id)
        ->orderBy('id', 'desc')
        ->first();
        $articleNext = Article::where('id', '>', $id)
            ->orderBy('id', 'asc')
                ->first();
        $postRandom = Article::inRandomOrder()->where('id', '!=', $id)
                    ->where(['status' => 1, 'article_category_id' => 2, 'is_deleted' => 0])
                    ->limit(2)
                    ->get();

        $this->data['articles'] = $articles;
        $this->data['ishots'] = $ishots;
        $this->data['iscommons'] = $iscommons;

        $this->data['articlePrevious'] = $articlePrevious;
        $this->data['articleNext'] = $articleNext;
        $this->data['postRandom'] = $postRandom;

        return view('frontend.article.showFengshui', $this->data);
    }
    public function isHot(Request $request, $slug, $id)
    {
        $articles = Article::findOrFail($id);
        $ishots = Article::where(['is_hot' => 1, 'status' => 1, 'article_category_id' => 2, 'is_deleted' => 0])->latest()->take(5)->get();
        $iscommons = Article::where(['is_common' => 1, 'status' => 1, 'article_category_id' => 2, 'is_deleted' => 0])->latest()->take(5)->get();

        $this->data['articles'] = $articles;
        $this->data['ishots'] = $ishots;
        $this->data['articles'] = $articles;
        $this->data['iscommons'] = $iscommons;

        return view('frontend.article.ishot', $this->data);
    }
}
