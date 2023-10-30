<?php

namespace App\Http\Controllers;

use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingRepository;
    public function __construct(SettingRepository $settingRepository)
    {
        $this->middleware(['auth', 'auto_check_premission']);
        $this->settingRepository = $settingRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = $this->settingRepository->index();
        return view('Settings.index', compact('setting'));
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
        //
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
            'commission_rate' => "required",
            'about_app' => "required",
        ]);

        $setting = $this->settingRepository->update($request->all(), $id);
        if ($setting) {
            return redirect()->back()->with('success', 'تم تعديل البيانات بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}