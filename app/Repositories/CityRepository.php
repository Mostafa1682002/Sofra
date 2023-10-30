<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Models\Category;
use App\Models\City;

class CityRepository implements BaseInterface
{
    public function index()
    {
        $cities = City::paginate(15);
        return $cities;
    }
    public function show($id)
    {
    }
    public function create()
    {
    }
    public function store($request)
    {
        $city = City::create($request);
        return $city;
    }
    public function edit($id)
    {
    }
    public function update($request, $id)
    {
        $city = City::findOrFail($id)->update($request);
        return $city;
    }
    public function destroy($id)
    {
        $city = City::findOrFail($id)->delete();
        return $city;
    }
}