<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
    }


    public function profile(Request $request)
    {
        $profile = auth()->user();
        $roles = Role::all();
        $userRole = $profile->roles->pluck('name', 'name')->all();
        return view('Profile.index', compact('profile', 'roles', 'userRole'));
    }

    public function updateProfile(Request $request)
    {
        $profile = auth()->user();
        $request->validate([
            'name' => "required|unique:users,name,$profile->id",
            'email' => "required|email|unique:users,email,$profile->id",
            'password' => "confirmed"
        ]);

        $data = $request->except('password');
        if ($request->has('password') && !empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }
        $profile->update($data);
        return redirect()->back()->with('success', 'تم تحديث البيانات  بنجاح');
    }
}
