<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->data['controllerName'] = 'upload';
    }

    public function images(Request $request)
    {
        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $object = trim($request->input('object', 'products'), '');

            foreach($file as $files) {
                $filename = $files->getClientOriginalName();
                $extension = $files->getClientOriginalExtension();
//                $picture = sha1($filename . time()) . '.' . $extension;
                $picture = str_slug($filename) . '.' . $extension;

                /**
                 * Path to the 'public' folder
                 */
                $path_image = '/tmp/';
                $path = public_path($path_image);

                // tao thu muc
                if (! is_dir ( $path )) {
                    mkdir ( $path, 0777, true );
                    if( chmod($path, 0777) ) {
                        // more code
                        chmod($path, 0755);
                    }
                }
                //specify your folder

                $destinationPath = $path;
                $files->move($destinationPath, $picture);
//                $destinationPath1='http://'.$_SERVER['HTTP_HOST'].'/files_clients/' .$folder[0]->folder. '/';
                $filest = array();
                $filest['name'] = $path_image.$picture;
                $filest['size'] = $this->get_file_size($destinationPath.$picture);
//                $filest['url'] = $destinationPath1.$picture;
//                $filest['thumbnailUrl'] = $destinationPath1.$picture;
                $filesa['files'][] = $filest;
            }

            return $filesa;
        }
    }

    public function index(Request $request)
    {
        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $object = trim($request->input('object', 'products'), '');

            foreach($file as $files) {
                $filename = $files->getClientOriginalName();
                $extension = $files->getClientOriginalExtension();
                $picture = sha1($filename . time()) . '.' . $extension;

                /**
                 * Path to the 'public' folder
                 */
                $path_image = 'app/public/data/'.$object.'/';
                $path_image .= date("Y/m/d/");

                $path = storage_path($path_image);

                // tao thu muc
                if (! is_dir ( $path )) {
                    mkdir ( $path, 0777, true );
                    if( chmod($path, 0777) ) {
                        // more code
                        chmod($path, 0755);
                    }
                }
                //specify your folder

                $destinationPath = $path;
                $files->move($destinationPath, $picture);
//                $destinationPath1='http://'.$_SERVER['HTTP_HOST'].'/files_clients/' .$folder[0]->folder. '/';
                $filest = array();
                $filest['name'] = $path_image.$picture;
                $filest['size'] = $this->get_file_size($destinationPath.$picture);
//                $filest['url'] = $destinationPath1.$picture;
//                $filest['thumbnailUrl'] = $destinationPath1.$picture;
                $filesa['files'][] = $filest;
            }

            return $filesa;
        }
    }

    // add more customized code available at https://github.com/blueimp/jQuery-File-Upload
    // in https://github.com/blueimp/jQuery-File-Upload/blob/master/server/php/UploadHandler.php
    /*
     * jQuery File Upload Plugin PHP Class
     * https://github.com/blueimp/jQuery-File-Upload
     *
     * Copyright 2010, Sebastian Tschan
     * https://blueimp.net
     *
     * Licensed under the MIT license:
     * http://www.opensource.org/licenses/MIT
     */
    protected function get_file_size($file_path, $clear_stat_cache = false) {
        if ($clear_stat_cache) {
            if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                clearstatcache(true, $file_path);
            } else {
                clearstatcache();
            }
        }
        return $this->fix_integer_overflow(filesize($file_path));
    }
    protected function fix_integer_overflow($size) {
        if ($size < 0) {
            $size += 2.0 * (PHP_INT_MAX + 1);
        }
        return $size;
    }
}

