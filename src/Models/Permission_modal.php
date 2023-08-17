<?php

namespace role\rolebasesystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission_modal extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    public $timestamps = false;

    public function getAllPermission($roleId)
    {
        $permissions = Permission_modal::select('permissions.id as permission_id', 'permissions.slug')
            ->from("permissions")
            ->join("mm_roles_permissions", "mm_roles_permissions.permission_id", "=", "permissions.id")
            ->where("mm_roles_permissions.role_id", "=", $roleId)
            ->get()->toArray();
        $permissions_slug = array_reduce($permissions, function ($result, $item) {
            $result[$item['slug']] = TRUE;
            return $result;
        }, array());
        return $permissions_slug;
    }

    public function getPermission()
    {
        return Permission_modal::select('permissions.id as permission_id', 'permissions.permission', 'permission_group.id as permission_group_id', 'permission_group.permission_group')
            ->from("permissions")
            ->leftjoin("permission_group", "permission_group.id", "=", "permissions.permission_group_id")
            ->get();
    }

    public function addPermission($permissionData)
    {
        return  Permission_modal::insert($permissionData);
    }

    public function editPermission($permissionId, $editData)
    {
        return Permission_modal::where('id', $permissionId)->update($editData);
    }

    public function deletePermission($permissionId)
    {
        return  Permission_modal::where('id', $permissionId)->delete();
    }
}
