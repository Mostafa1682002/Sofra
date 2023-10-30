<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserRepository implements BaseInterface
{
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate(20);
        return $users;
    }
    public function show($id)
    {
    }
    public function create()
    {
        $roles = Role::all();
        return $roles;
    }
    public function store($data)
    {
        $user = User::create($data);
        $user->assignRole($data['roles']);
        return $user;
    }
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return compact('user', 'roles', 'userRole');
    }

    public function update($data, $id)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($data['roles']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $user;
    }
}