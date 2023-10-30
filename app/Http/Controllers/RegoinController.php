<?php

namespace App\Http\Controllers;

use App\Repositories\RegoinRepository;
use Illuminate\Http\Request;

class RegoinController extends Controller
{
    protected $regoinRepository;
    public function __construct(RegoinRepository $regoinRepository)
    {
        $this->middleware(['auth', 'auto_check_premission']);
        $this->regoinRepository = $regoinRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->regoinRepository->index();
        return view('Regoins.index', $data);
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
        $regoin = $this->regoinRepository->store($request->all());
        if ($regoin) {
            return  redirect()->back()->with('success', 'تم اضافه الحي بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
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
        $regoin = $this->regoinRepository->update($request->all(), $id);
        if ($regoin) {
            return  redirect()->back()->with('success', 'تم تعديل الحي بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $regoin = $this->regoinRepository->destroy($id);
        if ($regoin) {
            return  redirect()->back()->with('success', 'تم حذف الحي بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }
}