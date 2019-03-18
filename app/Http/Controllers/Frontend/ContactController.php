<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\SlideShow;
use App\Models\Contact;
use App\Http\Requests\FeContactRequest;
use PhpParser\Node\Expr\AssignOp\Concat;

class ContactController extends Controller
{
    protected $data = []; // the information we send to the view
    public function __construct()
    {
        $this->_data['title'] = 'Liên hệ';
        $this->_data['controllerName'] = 'fecontact';
        $this->_model = new Contact;
    }

    public function index(Request $request)
    {
        return view('frontend.contact.index', $this->data);
    }

    public function store(FeContactRequest $request)
    {
        $data = $request->all();
        $object = $this->_model->create($data);
        return back()->with('message', 'Thông tin của bạn đã được lưu lại.
         Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất. Chân thành cảm ơn!');
    }
}
