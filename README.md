# Rolebase System

[![Latest Version on Packagist](https://img.shields.io/packagist/v/role/rolebasesystem.svg?style=flat-square)](https://packagist.org/packages/role/rolebasesystem)
[![Total Downloads](https://img.shields.io/packagist/dt/role/rolebasesystem.svg?style=flat-square)](https://packagist.org/packages/role/rolebasesystem)
[![License](https://img.shields.io/github/license/kaushaltest/rolebasesystem.svg?style=flat-square)](LICENSE.md)

The Role-Based System Laravel Package provides a robust and flexible role management solution for Laravel applications. Easily implement and manage user roles, permissions, and access control with this package.

## Indexing
1. [Features](#features)
2. [Installation](#installation)
3. [Migration](#migration)
4. [Publish](#publish)
5. [Routes](#routes)
6. [Run](#run)


## Features

- Define and manage user roles with associated permissions.
- Grant or revoke permissions to roles and individual users.
- Protect routes and actions based on user roles and permissions.
- Simplified and intuitive API for role and permission management.
- Integration with Laravel's built-in authentication system.
- Easily extendable and customizable to fit your application's needs.

## Installation

You can install the package via composer:

```bash
composer require role/rolebasesystem
```
## Migration

- After you install package you have to migrate tables. 
- You must check first you env file have DB connection ? if no then first connect you DB. 
- Your DB connection is success then hit this command:
- Migration command successfully run then your DB show four tables permissions, permission_group, role, role_permissions.

```bash
php artisan migrate
```

## Publish 

- After migration complete we will publish package. 
- View folder store some package view files ('vendor/rolebasesystem/').
- Controller store package controller inside (role/rolebasesystem/).
- Model store package model inside (role/rolebasesystem/).
- Able change package view,controller,model.
```bash
 php artisan vendor:publish --tag=rolebasesystem
```
## Routes 

- route use in this package 
```bash
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
```

## Run 

-run this command:
```bash
php artisan serve 
```
- Hit this url 'http://127.0.0.1:8000/role'