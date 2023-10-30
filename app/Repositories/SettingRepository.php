<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Models\Setting;

class SettingRepository implements BaseInterface
{
    public function index()
    {
        $setting = Setting::first();
        return $setting;
    }
    public function show($request)
    {
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
    public function update($request, $id)
    {
        $setting = Setting::findOrFail($id)->update($request);
        return $setting;
    }

    public function destroy($id)
    {
    }
}