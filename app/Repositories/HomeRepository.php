<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Models\User;
use Spatie\Permission\Models\Role;

class HomeRepository implements BaseInterface
{
    public function index()
    {
    }
    public function show($request)
    {
        $profile = $request->user();
        $roles = Role::all();
        $userRole = $profile->roles->pluck('name', 'name')->all();
        return  compact('profile', 'roles', 'userRole');
    }
    public function create()
    {
    }
    public function store($request)
    {
    }
    public function edit($id)
    {
    }
    public function update($data, $id)
    {
        $profile = User::findOrFail($id);
        $profile->update($data);
        return $profile;
    }

    public function destroy($id)
    {
    }
}