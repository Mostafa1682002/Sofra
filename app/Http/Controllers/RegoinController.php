<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Regoin;
use Illuminate\Http\Request;

class RegoinController extends Controller
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
        $regoins = Regoin::paginate(15);
        $cities = City::all();
        return view('Regoins.index', compact('regoins', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required",
            'city_id' => "required|exists:cities,id"
        ]);
        Regoin::create($request->all());
        return  redirect()->back()->with('success', 'تم اضافه الحي بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => "required",
            'city_id' => "required|exists:cities,id"
        ]);
        Regoin::findOrFail($id)->update($request->all());
        return  redirect()->back()->with('success', 'تم تعديل الحي بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Regoin::findOrFail($id)->delete();
        return  redirect()->back()->with('success', 'تم حذف الحي بنجاح');
    }
}
