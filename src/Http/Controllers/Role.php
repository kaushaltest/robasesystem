<?php

namespace role\rolebasesystem\Http\Controllers;

use Illuminate\Http\Request;
use role\rolebasesystem\Models\Role_model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
class Role extends Controller
{
    protected $roleModel;
    public function __construct()
    {
        $this->roleModel = new Role_model();
    }
    public function getRole(Request $request)
    {
        $roleList = $this->roleModel->getRole();
        if (count($roleList)) {
            return response()->json([
                'success' => 1,
                'data' => $roleList,
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'data' => [],
            ], 200);
        }
    }

    public function addRole(Request $request)
    {
        $addData=[
            "role_name" => Str::ucfirst($request->input('role_name')),
            "last_updated_on"=>Carbon::now()->timestamp,
            "created_on"=>Carbon::now()->timestamp,
        ];
        $status = $this->roleModel->addRole($addData);
        if ($status) {
            return response()->json([
                'success' => 1,
                'message' => "Role add successfully",
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'message' => "Role not added",
            ], 200);
        }
    }

    public function editRole(Request $request)
    {

        $editData=[
            "role_name" => Str::ucfirst($request->input('role_name')),
            "last_updated_on"=>Carbon::now()->timestamp,
        ];

        $status = $this->roleModel->editRole($request->input('id'), $editData);
        if ($status) {
            return response()->json([
                'success' => 1,
                'message' => "Role update successfully",
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'message' => "Role not updated",
            ], 200);
        }
    }

    public function deleteRole(Request $request)
    {
        $status = $this->roleModel->deleteRole($request->input('role_id'));
        if ($status) {
            return response()->json([
                'success' => 1,
                'message' => "Role delete successfully",
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'message' => "Role not deleted",
            ], 200);
        }
    }
}
