<?php

namespace Role\Rolebasesystem\Models;

use App\Http\Controllers\Permissiongroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission_of_roles_model extends Model
{
    use HasFactory;
    protected $table = 'role_permissions';
    public $timestamps = false;

    public function getPermissionOfRoles($roleId)
    {
        $permissionGroupArr = [];
        $permissiongGroupList = Permission_group_modal::select("id","permission_group")
            ->get();
        if (count($permissiongGroupList) > 0) {
            foreach ($permissiongGroupList as $group) {
                $status = Permission_modal::select("id")
                ->where("permission_group_id",$group['id'])
                ->get();
                if(count($status)>0)
                {
                    array_push($permissionGroupArr, ['permission_group' => $group['permission_group']]);
                }
               
            }
        }
        $permissionList = Permission_modal::select("permissions.id as permission_id", "permissions.slug", "permissions.permission", "permission_group.permission_group")
            ->from("permissions")
            ->leftjoin("permission_group", "permission_group.id", "=", "permissions.permission_group_id")
            ->get();
        $permissionAccessList =  Permission_of_roles_model::select("permission_id as permission_access_id")
            ->where("role_id", "=", $roleId)
            ->get();
        return [$permissionGroupArr, $permissionList, $permissionAccessList];
    }

    public function savePermission($permission_data)
    {
        return Permission_of_roles_model::insert($permission_data);
    }

    public function deletePermission($roleId)
    {
        return Permission_of_roles_model::where('role_id', $roleId)->delete();
    }
}
