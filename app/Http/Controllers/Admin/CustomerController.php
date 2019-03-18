<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CustomersRequest;
use App\Http\Requests\CustomersChangePasswordRequest;
use App\Helpers\General;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    private $_data = array();

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
//        $this->middleware('auth');
        $this->_data['title'] = 'khách hàng';
        $this->_data['controllerName'] = 'customers';
        $this->_model = new Customer();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $message = $request->session()->get('message', '');
        $this->_data['message'] = json_decode($message, 1);
        $this->_data['status'] = ['' => ''] + $this->_model->getStatusFilter();

        return view("admin.{$this->_data['controllerName']}.index", $this->_data);
    }

    public function show(Request $request)
    {
        $limit = $request->input('limit', env('LIMIT_LIST', 10));
        if (!$request->has('page')) {
            $offset = $request->input('offset', 0);
            $page = round($offset / $limit) + 1;
            $request->request->add(['page' => $page]);
        }

        $objects = Customer::where('customers.is_deleted', 0);

        $status = $request->input('status');
        if ($status) {
            $objects->where(function ($query) use ($status) {
                $query->where('customers.status', $status);
            });
        }

        $keyword = $request->input('search', '');
        if ($keyword) {
            $objects->where(function ($query) use ($keyword) {
                $query->where('customers.fullname', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('customers.email', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('customers.phone', 'LIKE', '%' . $keyword . '%');
            });
        }

        $sort = $request->input('sort', 'customers.id');
        $order = $request->input('order', 'desc');
        if ($sort && $order) {
            $objects->orderBy($sort, $order);
        }

        $objects = $objects->paginate($limit, [
            \DB::raw('customers.*')
        ])->toArray();

        $objects['rows'] = isset($objects['data']) ? array_values($objects['data']) : [];

        return response()->json($objects);
        dd($objects);
    }

    public function create(Request $request)
    {
        return view("admin.{$this->_data['controllerName']}.create ", $this->_data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required',
            'email' => 'required|email|unique:customers',
            'password' => 'required',
//            'birthdate' => 'date|date_format:d-m-Y'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        if (isset($data['birthdate']) && $data['birthdate']) {
            $data['birthdate'] = date('Y-m-d', strtotime($data['birthdate']));
        }

        $object = Customer::create($data);

        if ($object) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'rs' => 1,
                    'msg' => 'Thêm mới ' . $this->_data['title'] . ' thành công'
                ]);
            }

            return redirect()->route($this->_data['controllerName'] . '.index');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'rs' => 0,
                'msg' => 'Thêm mới ' . $this->_data['title'] . ' không thành công',
            ]);
        }

        return redirect()->route($this->_data['controllerName'] . '.create');
    }

    public function edit(Request $request, $id)
    {
        $object = Customer::find($id);

        if (!$object) {
            abort(404, 'Không tìm thấy người dùng');
        }

        $object['birthdate'] = $object['birthdate'] && $object['birthdate'] != '0000-00-00'
            ? date('d-m-Y', strtotime($object['birthdate'])) : '';

        $this->_data['object'] = $object;

        $this->_data['id'] = $id;

        return view("admin.{$this->_data['controllerName']}.create", $this->_data);
    }

    /**
     * Enter description here ...
     * @param JobLevelsRequest $request
     * @param unknown $id
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function update(Request $request, $id)
    {
        $object = Customer::find($id);

        if (!$object) {
            abort(404, 'Không tìm thấy người dùng');
        }

        $data = $request->all();

        if (isset($data['birthdate']) && $data['birthdate']) {
            $data['birthdate'] = date('Y-m-d', strtotime($data['birthdate']));
        }
        if (isset($data['email'])) unset($data['email']);

        $rs = $object->update($data);

        if ($rs) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'rs' => 1,
                    'msg' => 'Cập nhật ' . $this->_data['title'] . ' thành công'
                ]);
            }

            return redirect()->route($this->_data['controllerName'] . '.index');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'rs' => 0,
                'msg' => 'Cập nhật ' . $this->_data['title'] . ' không thành công',
            ]);
        }

        return response()->route($this->_data['controllerName'] . '.edit', ['id' => $id]);
    }

    public function destroy(Request $request, $id)
    {
        $object = Customer::find($id);

        if (!$object) {
            return response()->json([
                'rs' => 0,
                'messase' => 'Không tìm thấy người dùng: ' . $id
            ]);
        }

        $object->is_deleted = 1;
        $object->save();

        if ($object) {
            return response()->json([
                'rs' => 1,
                'msg' => 'Xóa nhân sự thành công',
            ]);
        }

        return response()->json([
            'rs' => 0,
            'msg' => 'Xóa nhân sự không thành công'
        ]);
    }

    public function profile(Request $request)
    {
        $object = backpack_auth()->user();

        if (!$object) {
            abort(404, 'Không tìm thấy người dùng');
        }

        $object['birthdate'] = $object['birthdate'] && $object['birthdate'] != '0000-00-00'
            ? date('d-m-Y', strtotime($object['birthdate'])) : '';

        $this->_data['object'] = $object;

        $this->_data['id'] = $object->id;
        $this->_data['action'] = 'profile';

        return view("admin.{$this->_data['controllerName']}.create", $this->_data);
    }

    public function profile_update(Request $request)
    {
        $object = backpack_auth()->user();

        if (!$object) {
            abort(404, 'Không tìm thấy người dùng');
        }

        $data = $request->all();

        if (isset($data['birthdate']) && $data['birthdate']) {
            $data['birthdate'] = date('Y-m-d', strtotime($data['birthdate']));
        }
        if (isset($data['email'])) unset($data['email']);

        $rs = $object->update($data);

        if ($rs) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'rs' => 1,
                    'msg' => 'Cập nhật ' . $this->_data['title'] . ' thành công'
                ]);
            }

            return redirect()->route($this->_data['controllerName'] . '.index');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'rs' => 0,
                'msg' => 'Cập nhật ' . $this->_data['title'] . ' không thành công',
            ]);
        }

        return response()->route($this->_data['controllerName'] . '.edit', ['id' => $object->id]);
    }

    public function change_password(Request $request)
    {
        return view("admin.{$this->_data['controllerName']}.change-password", $this->_data);
    }

    /**
     * Enter description here ...
     * @param JobLevelsRequest $request
     * @param unknown $id
     * @return Ambigous <\Illuminate\Routing\Redirector, \Illuminate\Http\RedirectResponse>
     * @author HaLV
     */
    public function change_password_store(Request $request)
    {
        $this->validate($request, [
            'password_new' => 'required',
            'password_confirm' => 'required|same:password_new'
        ], [
            "password_new.required" => "Vui lòng nhập mật khẩu!",
            "password_confirm.required" => 'Mật khẩu xác nhận không đúng, vui lòng nhập lại!',
            "password_confirm.same" => 'Mật khẩu xác nhận không đúng, vui lòng nhập lại!'
        ]);

        $object = backpack_auth()->user();
        $data = $request->all();

        if (!Hash::check($data['password_old'], $object->password)) {
            return redirect(route('customers.change-password'))
                ->withInput($request->input())
                ->withErrors([
                    'password_old' => 'Mật khẩu cũ chưa đúng',
                ]);
        }

        $object->password = Hash::make($request->input('password_new'));
        $object->save();

        if ($object) {
            $request->session()->flash('message', json_encode([
                'title' => 'Thông báo',
                'text' => 'Đổi mật khẩu thành công.',
                'type' => 'success',
            ]));
        } else {
            $request->session()->flash('message', json_encode([
                'title' => 'Thông báo',
                'text' => 'Đổi mật khẩu không thành công.',
                'type' => 'warring',
            ]));
        }

        return redirect()->route('customers.change-password');
    }

    /**
     * tạo lại mật khẩu cho user
     * @param unknown $id
     * @return \Illuminate\View\View
     * @author HaLV
     */
    public function showResetPassword($id)
    {
        $this->_data['id'] = $id;

        return view("admin.{$this->_data['controllerName']}.reset-password", $this->_data);
    }

    public function postResetPassword(Request $request, $id)
    {
        $this->validate($request, [
            'password_new' => 'required',
            'password_confirm' => 'required|same:password_new'
        ], [
            "password_new.required" => "Vui lòng nhập mật khẩu!",
            "password_confirm.required" => 'Mật khẩu xác nhận không đúng, vui lòng nhập lại!',
            "password_confirm.same" => 'Mật khẩu xác nhận không đúng, vui lòng nhập lại!'
        ]);

        $object = Customer::find($id);

        if (!$object) {
            return response()->json([
                'rs' => 0,
                'messase' => 'Không tìm thấy người dùng: ' . $id
            ]);
        }

        $object->password = Hash::make($request->input('password_new'));
        $object->save();

        if ($object) {
            $request->session()->flash('message', json_encode([
                'title' => 'Thông báo',
                'text' => 'Tạo lại mật khẩu thành công.',
                'type' => 'success',
            ]));

            return redirect()->route($this->_data['controllerName'] . ".index");
        }

        $request->session()->flash('message', json_encode([
            'title' => 'Thông báo',
            'text' => 'Tạo lại mật khẩu không thành công.',
            'type' => 'warring',
        ]));

        return redirect()->route("{$this->_data['controllerName']}.show-reset-password", ['id' => $id]);
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

    public function getCombogridData(Request $request)
    {
        $filter = [
            'offset' => $request->input('offset', 0),
            'limit' => $request->input('limit', env('LIMIT_LIST', 10)),
            'sort' => $request->input('sort', 'id'),
            'order' => $request->input('order', 'desc'),
            'search' => $request->input('q', ''),
        ];

        $limit = $request->input('limit', env('LIMIT_LIST', 10));
        if (!$request->has('page')) {
            $offset = $request->input('offset', 0);
            $page = round($offset / $limit) + 1;
            $request->request->add(['page' => $page]);
        }

        $objects = Customer::where('customers.id', '!=', 1)
            ->where('customers.is_deleted', 0);

        $keyword = $request->input('q', '');
        if ($keyword) {
            $objects->where(function ($query) use ($keyword) {
                $query->where('customers.name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('customers.email', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('customers.phone', 'LIKE', '%' . $keyword . '%');
            });
        }

        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');
        if ($sort && $order) {
            $objects->orderBy($sort, $order);
        }

        $objects = $objects->paginate($limit, [
            \DB::raw('customers.*')
        ])->toArray();

        return response()->json([
            'total' => $objects['total'],
            'rows' => isset($objects['data']) ? array_values($objects['data']) : [],
        ]);
    }

    public function getInfoCustomer($id)
    {
        $attributes = [
            'id' => $id,
            'is_deleted' => 0
            ];

     $data= Customer::where($attributes)->first();

        if (empty($data)) {
            return null;
        }
        return $data;

    }
}
