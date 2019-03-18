<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $fillable = ['name', 'route', 'created_at', 'updated_at'];

    public static function getPermissionsByUser($user_id)
    {
        $role_ids = \App\Models\UserHasRole::where('user_id', $user_id)
            ->join('roles', function ($join) {
                $join->on('roles.id', '=', 'user_has_roles.role_id')
                    ->where('roles.is_deleted', '=', 0);
            })
            ->pluck('role_id')->toArray();

        if ($role_ids) {
            $objects = self::select('permissions.route', 'role_has_permissions.permission_id')
                ->leftJoin('role_has_permissions', function ($join) use ($role_ids) {
                    $join->on('role_has_permissions.permission_id', '=', 'permissions.id')
                        ->whereIn('role_has_permissions.role_id', $role_ids);
                })
                ->where('permissions.parent_id', '>', 0)
                ->where('permissions.is_deleted', '=', 0)
                ->pluck('permission_id', 'route')->toArray();
        } else {
            $objects = self::select('permissions.route', 'is_deleted')
//                ->where('permissions.parent_id', '>', 0)
                ->where('permissions.is_deleted', '=', 0)
                ->pluck('is_deleted', 'route')->toArray();
        }
        return $objects;
    }
}