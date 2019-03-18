<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductCategory;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use App\Http\Requests\AssetFeatureRequest;
use App\Helpers\General;

class AssetCategoryController extends Controller
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
        $this->_data['title'] = 'Danh mục sản phẩm';
        $this->_data['controllerName'] = 'asset-category';
        $this->_model = new AssetCategory();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isRange = General::isRange();
        $this->_data['isRange'] = $isRange;
        $this->_data['status'] = ['' => ''] + $this->_model->getStatusFilter();
        return view("admin.{$this->_data['controllerName']}.index", $this->_data);
    }

    public function search(Request $request)
    {
        $filter = [
            'offset' => $request->input('offset', 0),
            'limit' => $request->input('limit', 10),
            'sort' => $request->input('sort', 'id'),
            'order' => $request->input('order', 'asc'),
            'search' => $request->input('search', ''),
            'status' => $request->input('status', 1),
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
        $orderOptions = General::getOrderOptions();
        $this->_data['orderOptions'] = $orderOptions;
        $this->_data['type'] = ['' => ''] + $this->_model->getType();

        $isRange = General::isRange();
        $this->_data['isRange'] = $isRange;

        return view("admin.{$this->_data['controllerName']}.create", $this->_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetFeatureRequest $request)
    {
        $data = $request->all();

        unset($data['_token']);

        $object = $this->_model->create($data);
        if ($object) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'rs' => 1,
                    'msg' => 'Thêm mới '.$this->_data['title'].' thành công'
                ]);
            }
            return redirect()->route("{$this->_data['controllerName']}.index");
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'rs' => 0,
                'msg' => 'Thêm mới ' . $this->_data['title'] . ' không thành công'
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

        $orderOptions = General::getOrderOptions();
        $this->_data['orderOptions'] = $orderOptions;
        $this->_data['type'] = ['' => ''] + $this->_model->getType();

        $isRange = General::isRange();
        $this->_data['isRange'] = $isRange;


        return view("admin.{$this->_data['controllerName']}.edit", $this->_data);
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

        if (!$object) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'rs' => 0,
                    'msg' => 'Lỗi không tồn tại'
                ]);
            }

            return redirect()->route("{$this->_data['controllerName']}.index");
        }

        $data = $request->all();


        unset($data['_token']);

        $object->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'rs' => 1,
                'msg' => 'Chỉnh sửa '.$this->_data['title'].' thành công'
            ]);
        }

        return redirect()->route("{$this->_data['controllerName']}.index");
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

        if (!$object || !$id) {
            return response()->json([
                'rs' => 0,
                'msg' => 'Xóa '.$this->_data['title'].' không thành công',
            ]);
        }

        $object->is_deleted = 1;

        $object->save();

        return response()->json([
            'rs' => 1,
            'msg' => 'Xóa '.$this->_data['title'].' thành công',
        ]);
    }

    public function ajaxGetCategoryByManufacturer($manufacturer_id)
    {
        $res = [];

        if (!empty($manufacturer_id)) {
            $res = ProductCategory::ajaxGetCategoryBymanufacturer($manufacturer_id);
        }

        return response()->json($res);
    }

    public function ajaxActive(Request $request)
    {
        $ids = $request->all()['ids'];

        if (!empty($ids)) {
            foreach ($ids as $id) {
                $object  = $this->_model->find($id);
                $object->status = 1;
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
    public function ajaxInactive(Request $request)
    {
        $ids = $request->all()['ids'];

        if (!empty($ids)) {
            foreach ($ids as $id) {
                $object  = $this->_model->find($id);
                $object->status = 0;
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
    public function ajaxDelete(Request $request)
    {
        $ids = $request->all()['ids'];

        if (!empty($ids)) {
            foreach ($ids as $id) {
                $object  = $this->_model->find($id);
                $object->is_deleted = 1;
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
}
