<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Helpers\General;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Log;
use Session;

class ProductController extends Controller
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
        $this->_data['title'] = 'Sản phẩm';
        $this->_data['controllerName'] = 'product';
        $this->_model = new Product();
    }

    public function import(Request $request)
    {
        return view("admin.{$this->_data['controllerName']}.import", $this->_data);
    }
    public function store_import(Request $request)
    {
        $data = $request->all();

        $file_name = storage_path($data['file']);

        $reader = ReaderFactory::create(Type::XLSX); // for XLSX files
//        $reader = ReaderFactory::create(Type::CSV); // for CSV files
        //$reader = ReaderFactory::create(Type::ODS); // for ODS files

        $reader->open($file_name);

        $row_field = 2;
        $start = 3;
        $map_default = [
            'name' => 'Tên Hàng',
            'unit' => 'Đơn vị',
            'amount' => 'Số Lượng Hàng Tồn',
            'is_home' => 'Trang Chủ',
        ];
        $fields = array_flip($map_default);

        $count_insert_success = 0;
        $count_update_success = 0;

        foreach ($reader->getSheetIterator() as $index_sheet => $sheet) {
            if ($index_sheet > 1) break;

            $map = [];
            foreach ($sheet->getRowIterator() as $index => $row) {
                // do stuff with the row
                if ($index==$row_field) {
                    foreach ($row as $i => $f) {
                        if (isset($fields[$f])) {
                            $fields[$f] = $i;
                        }
                    }
                    Log::info('$map: '.json_encode($map_default));
                    Log::info('$fields: '.json_encode($fields));
                    foreach ($map_default as $k => $f) {
                        $map[$k] = $fields[$f];
                    }

                } elseif ($index >= $start) {

                    if (empty($row) || count($row) < count($map)) continue;

                    $data = [];
                    $count_fields_null = 0;
                    foreach ($map as $k => $i) {
                        $data[$k] = is_string($row[$i]) ? trim($row[$i]) : $row[$i];
                        $count_fields_null += $data[$k] ? 0 : 1;
                    }

                    if ($count_fields_null==count($data)) continue;

                    Log::info('$fields: '.json_encode($data));

                    $object = Product::where('name', $data['name'])->first();

                    if ($object) {
                        $data = \App\Helpers\General::get_data_fillable(new Product(), $data);

                        Product::where('name', $data['name'])->update($data);

                        $count_update_success++;
                    }
//                    else {
//                        $rs = Product::create($data);
//                        if ($rs) {
//                            $count_insert_success++;
//                        }
//                    }
                }
            }
        }

        $reader->close();

        Log::info('Import sản phẩm thành công: Cập nhật-'.$count_update_success.' in '.($index - $start + 1).' rows');

        if ($count_insert_success || $count_update_success) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'rs' => 1,
                    'msg' => 'Import sản phẩm thành công: Cập nhật-'.$count_update_success.' in '.($index - $start + 1).' rows'
                ]);
            }

            return redirect()->route('product.index');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'rs' => 0,
                'msg' => 'Import sản phẩm không thành công',
            ]);
        }

        return redirect("/{$this->_data['controllerName']}/import");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->_data['status'] = ['' => ''] + $this->_model->getStatusFilter();
        $this->_data['status_home'] = ['' => ''] + $this->_model->getStatusHomeFilter();

        $product_codes = Product::where('is_deleted', '!=', -1)
            ->groupBy('code')
            ->orderBy('order', 'asc')
            ->pluck('code', 'code')->toArray();
        $this->_data['product_codes'] = ['' => ''] + $product_codes;

        return view("admin.{$this->_data['controllerName']}.index", $this->_data);
    }

    public function search(Request $request)
    {
        $filter = [
            'offset' => $request->input('offset', 0),
            'limit' => $request->input('limit', 10),
            'sort' => $request->input('sort', 'product_categories.id'),
            'order' => $request->input('order', 'asc'),
            'search' => $request->input('search', ''),
            'status' => $request->input('status', 'is_active'),
            'code' => $request->input('code', ''),
            'is_home' => $request->input('is_home', ''),
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
        $this->_data['menu_items'] = General::getMenuItems();
        $this->_data['orderOptions'] = General::getOrderOptions();

        return view("admin.{$this->_data['controllerName']}.create", $this->_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        unset($data['_token']);

//        $categoryModel = new ProductCategory();
//        $category = $categoryModel->find($data['category_id'])->toArray();
//        $data['manufacturer_id'] = $category['manufacturer_id'];

        if (empty($data['image_url'])) {
            $data['image_url'] = config('app.url');
        }

        $object = $this->_model->create($data);

        if ($object)
        {
            if ($object && isset($data['product_images'])) {
                $this->store_product_images($object->id, $data['product_images']);
            }

            if ($request->ajax() || $request->wantsJson()) {

                $request->session()->flash('error', 0);
                $request->session()->flash('message', 'Thêm mới '.$this->_data['title'].' thành công');

                return response()->json([
                    'rs' => 1,
                    'msg' => 'Thêm mới '.$this->_data['title'].' thành công',
                    'act' => 'add',
                    'link_edit' => route('product.edit', ['id' => $object->id])
                ]);
            }

            return redirect()->route("{$this->_data['controllerName']}.index");
        }

        if ($request->ajax() || $request->wantsJson()) {

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $object = $this->_model->find($id)->toArray();
        $this->_data['id'] = $id;
        $this->_data['object'] = $object;
        $this->_data['menu_items'] = General::getMenuItems();
        $this->_data['orderOptions'] = General::getOrderOptions();
        $this->_data['product_images'] = ProductImage::where('product_id', $id)->pluck('image', 'id');
        // dd(    $this->_data['menu_items']);
        return view("admin.{$this->_data['controllerName']}.create", $this->_data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $object  = $this->_model->find($id);

        if (!$object)
        {
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

        if (empty($data['image_url'])) {
            $data['image_url'] = config('app.url');
        }

        unset($data['_token']);

//        $categoryModel = new ProductCategory();
//        $category = $categoryModel->find($data['category_id'])->toArray();
//        $data['manufacturer_id'] = $category['manufacturer_id'];

        $rs = $object->update($data);

        if ($rs && isset($data['product_images'])) {
            $this->store_product_images($id, $data['product_images']);
        }

        if ($request->ajax() || $request->wantsJson()) {

            $request->session()->flash('error', 0);
            $request->session()->flash('message', 'Chỉnh sửa '.$this->_data['title'].' thành công');

            return response()->json([
                'rs' => 1,
                'msg' => 'Chỉnh sửa '.$this->_data['title'].' thành công',
                'act' => 'edit',
                'link_edit' => route('product.edit', ['id' => $object->id])
            ]);
        }

        return redirect()->route("{$this->_data['controllerName']}.index");
    }

    public function store_product_images($product_id, $product_images) {
        if (isset($product_images['delete'])) {
            ProductImage::where('product_id', $product_id)
                ->whereIn('id', $product_images['delete'])->delete();
            unset($product_images['delete']);
        }
        foreach ($product_images as $item) {
            if ($item['id']) continue;
            ProductImage::create([
                'product_id' => $product_id,
                'image' => $item['image'],
                'image_url' => config('app.url')
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $object  = $this->_model->find($id);

        if (!$object || !$id)
        {
            return response()->json([
                'rs' => 0,
                'msg' => 'Xóa '.$this->_data['title'].' không thành công',
            ]);
        }

        $object->is_deleted = 0;

        $object->save();

        return response()->json([
            'rs' => 1,
            'msg' => 'Xóa '.$this->_data['title'].' thành công',
        ]);
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function ajaxActive(Request $request) {

        $ids = $request->all()['ids'];

        if (!empty($ids))
        {
            foreach ($ids as $id)
            {
                $object  = $this->_model->find($id);
                $object->is_deleted = 0;
                $object->save();
            }
            return response()->json([
                'rs' => 1,
                'msg' => 'Kích hoạt '.$this->_data['title'].' thành công',
                'act' => 'active'
            ]);
        }

        return response()->json([
            'rs' => 1,
            'msg' => 'Kích hoạt '.$this->_data['title'].' không thành công',
            'act' => 'active'
        ]);
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function ajaxInactive(Request $request) {

        $ids = $request->all()['ids'];

        if (!empty($ids))
        {
            foreach ($ids as $id)
            {
                $object  = $this->_model->find($id);
                $object->is_deleted = 1;
                $object->save();
            }
            return response()->json([
                'rs' => 1,
                'msg' => 'Ngừng kích hoạt '.$this->_data['title'].' thành công',
                'act' => 'inactive'
            ]);
        }

        return response()->json([
            'rs' => 1,
            'msg' => 'Ngừng kích hoạt '.$this->_data['title'].' không thành công',
            'act' => 'inactive'
        ]);
    }

    /**
     * Enter description here ...
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function ajaxDelete(Request $request) {

        $ids = $request->all()['ids'];

        if (!empty($ids))
        {
            foreach ($ids as $id)
            {
                $object  = $this->_model->find($id);
                $object->is_deleted = -1;
                $object->save();
            }
            return response()->json([
                'rs' => 1,
                'msg' => 'Xóa '.$this->_data['title'].' thành công',
                'act' => 'delete'
            ]);
        }

        return response()->json([
            'rs' => 1,
            'msg' => 'Xóa '.$this->_data['title'].' không thành công',
            'act' => 'delete'
        ]);
    }

    public function ajaxGetDistrictByProvince($province_id)
    {
        $res = [];

        if (!empty($province_id))
        {
            $res = General::getDistrictOptionsByProvince($province_id);
        }

        return response()->json($res);
    }

    public function ajaxGetWardByDistrict($district_id)
    {
        $res = [];

        if (!empty($district_id))
        {
            $res = General::getWardOptionsByDistrict($district_id);
        }

        return response()->json($res);
    }
}
