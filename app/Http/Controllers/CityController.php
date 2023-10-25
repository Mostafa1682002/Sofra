<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auto_check_premission']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::paginate(15);
        return view('Cities.index', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required|unique:cities,name"
        ]);

        City::create($request->all());
        return  redirect()->back()->with('success', 'تم اضافه المدينه بنجاح');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => "required|unique:cities,name,$id"
        ]);

        City::findOrFail($id)->update($request->all());
        return  redirect()->back()->with('success', 'تم تعديل المدينه بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        City::findOrFail($id)->delete();
        return  redirect()->back()->with('success', 'تم حذف المدينه بنجاح');
    }
}
