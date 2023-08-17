<?php

namespace Role\Rolebasesystem\Http\Controllers;

use Illuminate\Http\Request;
use Role\Rolebasesystem\Models\Permission_group_modal;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
class Permissiongroup extends Controller
{
    protected $permissionGroupModel;
    public function __construct()
    {
        $this->permissionGroupModel = new Permission_group_modal();
    }

    
    public function getPermissionGroup(Request $request)
    {
        $permissionGroupList = $this->permissionGroupModel->getPermissionGroup();
        if (count($permissionGroupList)) {
            return response()->json([
                'success' => 1,
                'data' => $permissionGroupList,
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'data' => [],
            ], 200);
        }
    }

    public function addPermissionGroup(Request $request)
    {
        $addData=[
            "permission_group" =>  Str::ucfirst($request->input('permission_group')),
            "last_updated_on"=>Carbon::now()->timestamp,
            "created_on"=>Carbon::now()->timestamp,
        ];
        $status = $this->permissionGroupModel->addPermissionGroup($addData);
        if ($status) {
            return response()->json([
                'success' => 1,
                'message' => "Permission group add successfully",
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'message' => "Permission group not added",
            ], 200);
        }
    }

    public function editPermissionGroup(Request $request)
    {

        $editData=[
            "permission_group" =>  Str::ucfirst($request->input('permission_group')),
            "last_updated_on"=>Carbon::now()->timestamp,
        ];

        $status = $this->permissionGroupModel->editPermissionGroup($request->input('id'), $editData);
        if ($status) {
            return response()->json([
                'success' => 1,
                'message' => "Permission group update successfully",
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'message' => "Permission group not updated",
            ], 200);
        }
    }

    public function deletePermissionGroup(Request $request)
    {
        $status = $this->permissionGroupModel->deletePermissionGroup($request->input('role_id'));
        if ($status) {
            return response()->json([
                'success' => 1,
                'message' => "Permission group delete successfully",
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'message' => "Permission group not deleted",
            ], 200);
        }
    }
}
