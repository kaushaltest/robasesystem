<?php

namespace App\Models\role\rolebasesystem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission_group_modal extends Model
{

    use HasFactory;
    protected $table = 'permission_group';
    public $timestamps=false;


    public function getPermissionGroup()
    {
        return Permission_group_modal::select('id as permission_group_id', 'permission_group')->get();
    }

    public function addPermissionGroup($addData)
    {
        return  Permission_group_modal::insert($addData);
    }

    public function editPermissionGroup($permissionGroupId, $editData)
    {
        return Permission_group_modal::where('id', $permissionGroupId)->update($editData);
    }

    public function deletePermissionGroup($permissionGroupId)
    {
        return  Permission_group_modal::where('id', $permissionGroupId)->delete();
    }
}
