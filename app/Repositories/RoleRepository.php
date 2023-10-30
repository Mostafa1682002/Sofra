<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository implements BaseInterface
{
    public function index()
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(20);
        return $roles;
    }
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
        return compact('role', 'rolePermissions');
    }
    public function create()
    {
        $permissions = Permission::get();
        return $permissions;
    }
    public function store($request)
    {
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    }
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return  compact('role', 'permissions', 'rolePermissions');
    }
    public function update($request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return $role;
    }
    public function destroy($id)
    {
        $role = DB::table("roles")->where('id', $id)->delete();
        return $role;
    }
}