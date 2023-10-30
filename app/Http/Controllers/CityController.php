<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Repositories\CityRepository;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $cityRepository;
    public function __construct(CityRepository $cityRepository)
    {
        $this->middleware(['auth', 'auto_check_premission']);
        $this->cityRepository = $cityRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = $this->cityRepository->index();
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

        $city = $this->cityRepository->store($request->all());
        if ($city) {
            return  redirect()->back()->with('success', 'تم اضافه المدينه بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => "required|unique:cities,name,$id"
        ]);


        $city = $this->cityRepository->update($request->all(), $id);
        if ($city) {
            return  redirect()->back()->with('success', 'تم تعديل المدينه بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $city = $this->cityRepository->destroy($id);
        if ($city) {
            return  redirect()->back()->with('success', 'تم حذف المدينه بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }
}