<?php

namespace Role\Rolebasesystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role_model extends Model
{
    use HasFactory;
    protected $table = 'role';
    public $timestamps=false;

    public function getRole()
    {
        return Role_model::select('id as role_id', 'role_name')->get();
    }

    public function addRole($roleData)
    {
        return  Role_model::insert($roleData);
    }

    public function editRole($roleId, $editData)
    {
        return Role_model::where('id', $roleId)->update($editData);
    }

    public function deleteRole($roleId)
    {
        return  Role_model::where('id', $roleId)->delete();
    }
}
