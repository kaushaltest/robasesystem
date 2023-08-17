<?php

namespace role\rolebasesystem\Http\Controllers;

use Illuminate\Http\Request;
use role\rolebasesystem\Models\Permission_of_roles_model;
use role\rolebasesystem\Models\Permission_modal;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
class Permissionofroles extends Controller
{
    protected $permissionOfRolesModel;
    protected $permissionModel;
    public function __construct()
    {
        $this->permissionOfRolesModel = new Permission_of_roles_model();
        $this->permissionModel = new Permission_modal();
    }

    public function getPermissionOfRoles(Request $request)
    {
        $permissionList = $this->permissionOfRolesModel->getPermissionOfRoles($request->input('role_id'));
        if (count($permissionList)) {
            return response()->json([
                'success' => 1,
                'data' => $permissionList,
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'data' => "",
            ], 200);
        }
    }

    public function savePermission(Request $request)
    {

        $permissionsData = [];
        if($request->input("chk_permissions"))
        {
            foreach ($request->input("chk_permissions") as $per) {
                array_push($permissionsData, ["permission_id" => $per, "role_id" => $request->input("drp_role"),    
                "last_updated_on"=>Carbon::now()->timestamp,
                "created_on"=>Carbon::now()->timestamp,]);
            }
        }
        $deletestatus = $this->permissionOfRolesModel->deletePermission($request->input("drp_role"));
        $status = $this->permissionOfRolesModel->savePermission($permissionsData);
        if ($status) {
            $permission = $this->permissionModel->getAllPermission();
            $request->session()->put('permissions', $permission);
            return response()->json([
                'success' => 1,
                'message' => 'Permission save successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'Permission not saved',
            ], 200);
        }
    }
}
