<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Validator;

class PageController extends Controller
{
    public function index($slug)
    {
        $page = Page::findBySlug($slug);

        if (!$page)
        {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $this->data['title'] = $page->title;
        $this->data['page'] = $page->toArray();
        $this->data['action'] = $slug;
        
        if (!$page->template) $page->template = 'default';

        return view('pages.'.$page->template, $this->data);
    }
}
