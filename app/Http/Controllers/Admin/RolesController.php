<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Auth;
use App\Models\Permissions;
use App\Models\UserHasRole;
use Illuminate\Http\Request;

use App\Models\Roles;
use App\Models\RoleHasPermission;

use App\Http\Requests\RolesRequest;

use App\Helpers\General as Helper;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Ixudra\Curl\Facades\Curl;

class RolesController extends Controller
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
        $this->_data['title'] = 'Vai trò';
        $this->_data['controllerName'] = 'roles';
    }
    public function remove_user($role_id, $user_id) {
        \App\Models\UserHasRole::where('role_id', $role_id)
            ->where('user_id', $user_id)
            ->delete();

        return response()->json([
            'rs' => 1,
            'msg' => 'Xoá nhân sự thành công khỏi vai trò',
        ]);
    }
    public function detail($id) {
        $object = Roles::where('id', $id)
            ->select('*')
            ->first();
        $this->_data['object'] = $object;

        $has_permissions = RoleHasPermission::leftJoin('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where('role_id', $id)
            ->get()->toArray();

        $tmp = [];
        foreach($has_permissions as $item)
        {
            $tmp[$item['parent_id']][] = $item;
        }
        $this->_data['has_permissions'] = $tmp;

        $parent_permissions = Permissions::select('*')
            ->where('is_deleted', 0)
            ->where('parent_id', 0)
            ->pluck('name', 'id')
            ->toArray();
        $this->_data['parent_permissions'] = $parent_permissions;

        $users = UserHasRole::select('users.*')
            ->leftJoin('users', 'users.id', '=', 'user_has_roles.user_id')
            ->where('role_id', $id)
            ->get()->toArray();
        $this->_data['users'] = $users;

        return view("admin.{$this->_data['controllerName']}.detail", $this->_data);
    }

    public function getShowAll(Request $request) {
        $message = $request->session()->get('message', '');
        $this->_data['message'] = json_decode($message, 1);
        return view("admin.{$this->_data['controllerName']}.show-all", $this->_data);
    }

    /**
     * List staffs request
     * @return JSON
     * @author HaLV
     */
    public function getAjaxData(Request $request)
    {
        $limit = $request->input('limit', env('LIMIT_LIST', 10));
        if (!$request->has('page')) {
            $offset = $request->input('offset', 0);
            $page = round($offset / $limit) + 1;
            $request->request->add(['page' => $page]);
        }

        $objects = Roles::where('is_deleted', 0);

        $keyword = $request->input('search', '');
        if ($keyword) {
            $objects->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            });
        }

        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');
        if ($sort && $order) {
            $objects->orderBy($sort, $order);
        }

        $objects = $objects->paginate($limit, [
            \DB::raw('roles.*')
        ])->toArray();

        $objects['rows'] = isset($objects['data']) ? array_values($objects['data']) : [];
        unset($objects['data']);

        return response()->json($objects);
    }

    public function getAdd() {

        $childPermissions = Permissions::select('*')->where('is_deleted', 0)->where('parent_id', '<>', 0)->get()->toArray();

        $parentPermissions = Permissions::select('*')->where('is_deleted', 0)->where('parent_id', 0)->get()->toArray();

        $group_permissions = [];

        foreach($parentPermissions as $parent)
        {
            $group_permissions[$parent['id']] = [];

            foreach($childPermissions as $item)
            {
                if($item['parent_id'] == $parent['id'])
                {
                    $group_permissions[$parent['id']][] = $item;
                }
            }
        }

        $this->_data['parentPermissions'] = $parentPermissions;
        $this->_data['group_permissions'] = $group_permissions;

        return view("admin.{$this->_data['controllerName']}.add", $this->_data);
    }

    public function add_users(Request $request)
    {
        $data = $request->all();

        $rules = [
            'role_id' => 'required|integer',
            'user_ids' => 'required|array',
        ];

        $valid = Validator::make($data, $rules);

        if ($valid->fails())
        {
            return response()->json([
                'rs' => 0,
                'msg' => 'Dữ liệu nhập không hợp lệ',
                'errors' => $valid->errors()->messages(),
                'data' => $data
            ]);
        }

        foreach ($data['user_ids'] as $user_id) {
            $user_id = intval($user_id);

            if (!$user_id) continue;

            \App\Models\UserHasRole::firstOrCreate(['role_id' => $data['role_id'], 'user_id' => $user_id]);
        }

        Cache::flush();

        return response()->json([
            'rs' => 1,
            'msg' => 'Thêm nhân sự thành công',
        ]);
    }

    public function postAdd(RolesRequest $request) {

        $data = $request->all();

        unset($data['_token']);

        $role = Roles::create(['name' => $data['name']]);

        if ($role)
        {
            if(!empty($data['permissions']))
            {
                foreach ($data['permissions'] as $permission_id)
                {
                    RoleHasPermission::insert(['permission_id' => $permission_id, 'role_id' => $role->id]);
                }

                Cache::flush();
            }

            return redirect()->route('roles.index');
        }
        return redirect("/{$this->_data['controllerName']}/add");
    }

    public function getEdit($id) {
        $object = Roles::where('id', $id)
            ->select('*')
            ->first();

        if (!$object) {
            abort(404, 'Không tìm thấy vai trò: '.$id);
        }

        $permissions = RoleHasPermission::select('permission_id')
            ->where('role_id', $id)
            ->get()->toArray();

        $object = $object->toArray();

        $object['permissions'] = [];

        if(!empty($permissions))
        {
            foreach ($permissions as $item)
            {
                $object['permissions'][$item['permission_id']] = $item['permission_id'];
            }
        }

        $this->_data['object'] = $object;

        $childPermissions = Permissions::select('*')->where('is_deleted', 0)->where('parent_id', '<>', 0)->get()->toArray();

        $parentPermissions = Permissions::select('*')->where('is_deleted', 0)->where('parent_id', 0)->get()->toArray();

        $group_permissions = [];

        foreach($parentPermissions as $parent)
        {
            $group_permissions[$parent['id']] = [];

            foreach($childPermissions as $item)
            {
                if($item['parent_id'] == $parent['id'])
                {
                    $group_permissions[$parent['id']][] = $item;
                }
            }
        }

        $this->_data['parentPermissions'] = $parentPermissions;
        $this->_data['group_permissions'] = $group_permissions;

        return view("admin.{$this->_data['controllerName']}.edit", $this->_data);
    }

    public function postEdit(RolesRequest $request, $id) {

        $data = $request->all();

        unset($data['_token']);

        $rs = Roles::where('id', $id)->update(['name' => $data['name']]);

        if ($rs)
        {
            if(!empty($data['permissions']))
            {
                RoleHasPermission::where('role_id', $id)->delete();
                foreach ($data['permissions'] as $permission_id)
                {
                    RoleHasPermission::insert(['permission_id' => $permission_id, 'role_id' => $id]);
                }

                $request->session()->flash('message', json_encode([
                    'title' => 'Thông báo',
                    'text' => 'Cập nhật vai trò thành công.',
                    'type' => 'success',
                ]));

                Auth::forget_permissions();
                Cache::flush();
            }

            return redirect()->route('roles.index');
        }

        return redirect("/{$this->_data['controllerName']}/edit");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($id) {
            $rs = Roles::find($id)->update([
                'is_deleted' => 1
            ]);
            if ($rs) {
                return response()->json([
                    'rs' => 1,
                    'msg' => 'Xóa vai trò thành công',
                ]);
            }
        }

        return response()->json([
            'rs' => 0,
            'msg' => 'Xóa vai trò không thành công'
        ]);
    }
}
