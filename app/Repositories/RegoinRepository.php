<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Models\City;
use App\Models\Regoin;

class RegoinRepository implements BaseInterface
{
    public function index()
    {
        $regoins = Regoin::paginate(15);
        $cities = City::all();
        return compact('regoins', 'cities');
    }
    public function show($id)
    {
    }
    public function create()
    {
    }
    public function store($request)
    {
        $regoin = Regoin::create($request);
        return $regoin;
    }
    public function edit($id)
    {
    }
    public function update($request, $id)
    {
        $category = Regoin::findOrFail($id)->update($request);
        return $category;
    }
    public function destroy($id)
    {
        $regoin = Regoin::findOrFail($id)->delete();
        return $regoin;
    }
}