<?php
use role\rolebasesystem\Http\Controllers\Role;
use role\rolebasesystem\Http\Controllers\Permission;
use role\rolebasesystem\Http\Controllers\Permissiongroup;
use role\rolebasesystem\Http\Controllers\Permissionofroles;

Route::group(['middleware' => 'web', 'namespace' => 'role\rolebasesystem\Http\Controllers'], function () {
    //role 
    Route::view('/role', 'rolebasesystem::role');
    Route::get('/getrole', [Role::class, "getRole"]);
    Route::post('/addrole', [Role::class, "addRole"]);
    Route::post('/editrole', [Role::class, "editRole"]);
    Route::post('/deleterole', [Role::class, "deleteRole"]);

    //permission 
    Route::view('/permission', 'rolebasesystem::permission');
    Route::get('/getpermission', [Permission::class, "getPermission"]);
    Route::post('/addpermission', [Permission::class, "addPermission"]);
    Route::post('/editpermission', [Permission::class, "editPermission"]);
    Route::post('/deletepermission', [Permission::class, "deletePermission"]);

    //permission group
    Route::view('/permissiongroup', 'rolebasesystem::permissiongroup');
    Route::get('/getpermissiongroup', [Permissiongroup::class, "getPermissionGroup"]);
    Route::post('/addpermissiongroup', [Permissiongroup::class, "addPermissionGroup"]);
    Route::post('/editpermissiongroup', [Permissiongroup::class, "editPermissionGroup"]);
    Route::post('/deletepermissiongroup', [Permissiongroup::class, "deletePermissionGroup"]);


    //permission of roles
    Route::view('/permissionofroles', 'rolebasesystem::permissionofroles');
    Route::post('/getpermissionofroles', [Permissionofroles::class, "getPermissionOfRoles"]);
    Route::post('/savepermission', [Permissionofroles::class, "savePermission"]);
});
