<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Models\Category;

class CategoryRepository implements BaseInterface
{
    public function index()
    {
        $categories = Category::paginate(15);
        return $categories;
    }
    public function show($id)
    {
    }
    public function create()
    {
    }
    public function store($request)
    {
        $category = Category::create($request);
        return $category;
    }
    public function edit($id)
    {
    }
    public function update($request, $id)
    {
        $category = Category::findOrFail($id)->update($request);
        return $category;
    }
    public function destroy($id)
    {
        $category = Category::findOrFail($id)->delete();
        return $category;
    }
}