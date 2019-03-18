<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->data['controllerName'] = 'cache';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_img(Request $request)
    {
        $version = \App\Helpers\General::get_version_img(true);

        return response()->json([
            'rs' => 1,
            'ver' => $version
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_css(Request $request)
    {
        $version = \App\Helpers\General::get_version_css(true);
        
        return response()->json([
            'rs' => 1,
            'ver' => $version
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_js(Request $request)
    {
        $version = \App\Helpers\General::get_version_js(true);
        
        return response()->json([
            'rs' => 1,
            'ver' => $version
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_js_data(Request $request)
    {
        $version = \App\Helpers\General::get_version_js_data(true);

        return response()->json([
            'rs' => 1,
            'ver' => $version
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_all(Request $request)
    {
        Cache::flush();

        $version_data = \App\Helpers\General::get_version_js_data(true);
        $version_js = \App\Helpers\General::get_version_js(true);
        $version_css = \App\Helpers\General::get_version_css(true);

        return redirect('/');
    }
}

