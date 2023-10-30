<?php

namespace App\Http\Controllers;

use App\Repositories\HomeRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    protected $homeRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HomeRepository $homeRepository)
    {
        $this->middleware('auth');
        $this->homeRepository = $homeRepository;
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
        $data = $this->homeRepository->show($request);
        return view('Profile.index', $data);
    }

    public function updateProfile(Request $request)
    {
        $profile = $this->homeRepository->show($request)['profile'];
        $request->validate([
            'name' => "required|unique:users,name,$profile->id",
            'email' => "required|email|unique:users,email,$profile->id",
            'password' => "confirmed"
        ]);

        $data = $request->except('password');
        if ($request->has('password') && !empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }

        $updateProfile = $this->homeRepository->update($data, $profile->id);

        if ($updateProfile) {
            return redirect()->back()->with('success', 'تم تحديث البيانات  بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }
}