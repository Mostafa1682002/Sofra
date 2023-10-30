<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Models\Restaurant;

class RestaurantRepository implements BaseInterface
{
    public function index()
    {
        $restaurants = Restaurant::paginate(15);
        return $restaurants;
    }
    public function show($id)
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
        $restaurant = Restaurant::findOrFail($id)->update($request);
        return $restaurant;
    }
    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $image = $restaurant->image;
        $restaurant->delete();
        return compact('resturant', 'image');
    }
}