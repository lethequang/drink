<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductCategory;
use App\Models\PromotionFeatureVariant;
use App\Models\PromotionFeature;
use Illuminate\Http\Request;
use App\Http\Requests\AssetFeatureVariantRequest;
use App\Helpers\General;

class PromotionFeatureVariantController extends Controller
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
        $this->_data['title'] = 'Giá trị thuộc tính';
        $this->_data['controllerName'] = 'promotion-feature-variant';
        $this->_model = new PromotionFeatureVariant();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->_data['status'] = ['' => ''] + $this->_model->getStatusFilter();
        $this->_data['promotionFeature'] = ['' => ''] + $this->_model->getPromotionFeature();

        return view("admin.{$this->_data['controllerName']}.index", $this->_data);
    }

    public function search(Request $request)
    {
        $filter = [
            'offset' => $request->input('offset', 0),
            'limit' => $request->input('limit', 10),
            'sort' => $request->input('sort', 'asset_features_variants.id'),
            'order' => $request->input('order', 'asc'),
            'search' => $request->input('search', ''),
            'status' => $request->input('status', 1),
            'assetFeature' => $request->input('assetFeature', ''),

        ];

        $data = $this->_model->getListAll($filter);

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
            'sort' => $request->input('sort', 'promotion_features_variants.id'),
            'order' => $request->input('order', 'asc'),
            'search' => $request->input('search', ''),
            'status' => $request->input('status', 1),
            'assetFeature' => $request->input('assetFeature', ''),

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
        $assetFeature = array('' => '') + PromotionFeatureVariant::getPromotionFeature();
        $orderOptions = General::getOrderOptions();
        $this->_data['orderOptions'] = $orderOptions;
        $this->_data['assetFeature'] = $assetFeature;

        return view("admin.{$this->_data['controllerName']}.create", $this->_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetFeatureVariantRequest $request)
    {
        $data = $request->all();

        unset($data['_token']);

        $object = $this->_model->create($data);

        if ($object) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'rs' => 1,
                    'msg' => 'Thêm mới ' . $this->_data['title'] . ' thành công'
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

    public function storeAjax($from, $to, $feature_id)
    {

        $data['from'] = $from;
        $data['to'] = $to;
        $data['name'] = $from . "-" . $to;
        $data['description'] = $from . "-" . $to;
        $data['status'] = 1;
        $data['is_deleted'] = 0;
        $data['position'] = 1;
        $data['feature_id'] = $feature_id;

        $check = PromotionFeatureVariant::where('from',$from)->where('to', $to)->where('feature_id',$feature_id)->first();

        if ($from != $check['from'] && $to != $check['to'] && $feature_id != $check['feature_id']) {
            $object = $this->_model->create($data);
        }
        else{
            $object = $check;
        }

        return $object;


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

        $assetFeature = array('' => '') + PromotionFeatureVariant::getPromotionFeature();
        $orderOptions = General::getOrderOptions();
        $this->_data['orderOptions'] = $orderOptions;
        $this->_data['assetFeature'] = $assetFeature;

        return view("admin.{$this->_data['controllerName']}.edit", $this->_data);
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
                'msg' => 'Chỉnh sửa ' . $this->_data['title'] . ' thành công'
            ]);
        }

        return redirect()->route("{$this->_data['controllerName']}.index");
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

        $object->is_deleted = 1;

        $object->save();

        return response()->json([
            'rs' => 1,
            'msg' => 'Xóa ' . $this->_data['title'] . ' thành công',
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

    public function getAjaxDisableFeature($id)
    {
        $data = PromotionFeature::where('id', $id)->first()->toArray();

        if ($data['is_range'] == 1) {
            return response()->json([
                'is_range' => 1,

            ]);
        } else {
            return response()->json([
                'is_range' => 0,
            ]);
        }
    }

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
}
