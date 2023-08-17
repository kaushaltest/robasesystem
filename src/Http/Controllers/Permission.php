<?php

namespace Role\Rolebasesystem\Http\Controllers;

use Illuminate\Http\Request;
use Role\Rolebasesystem\Models\Permission_modal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class Permission extends Controller
{
    protected $permissionModel;
    public function __construct()
    {
        $this->permissionModel = new Permission_modal();
    }

   

    public function getPermission(Request $request)
    {
        $permissionList = $this->permissionModel->getPermission();
        if (count($permissionList)) {
            return response()->json([
                'success' => 1,
                'data' => $permissionList,
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'data' => [],
            ], 200);
        }
    }

    public function addPermission(Request $request)
    {
        
        $addData=[
            "permission" => Str::ucfirst($request->input('permission_name')),
            "permission_group_id" => $request->input('permission_group'),
            "slug"=>$this->createSlugName($request->input('permission_name')),
            "last_updated_on"=>Carbon::now()->timestamp,
            "created_on"=>Carbon::now()->timestamp,
        ];
        $permissionStatus = $this->permissionModel->addPermission($addData);
        if ($permissionStatus) {
            return response()->json([
                'success' => 1,
                'message' => "Permission add successfully",
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'message' => "Permission not added",
            ], 200);
        }
    }

    public function editPermission(Request $request)
    {

        $editData=[
            "permission" => Str::ucfirst($request->input('permission_name')),
            "permission_group_id" => $request->input('permission_group'),
            "slug"=>$this->createSlugName($request->input('permission_name')),
            "last_updated_on"=>Carbon::now()->timestamp,
        ];

        $permissionStatus = $this->permissionModel->editPermission($request->input('id'), $editData);
        if ($permissionStatus) {
            return response()->json([
                'success' => 1,
                'message' => "Permission update successfully",
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'message' => "Permission not updated",
            ], 200);
        }
    }

    public function deletePermission(Request $request)
    {
        $status = $this->permissionModel->deletePermission($request->input('permission_id'));
        if ($status) {
            return response()->json([
                'success' => 1,
                'message' => "Permission delete successfully",
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'message' => "Permission not deleted",
            ], 200);
        }
    }

    public function createSlugName($slugName)
    {
        $slug_lower= Str::lower($slugName);
        return Str::replace(" ","_",$slug_lower);
    }
}
