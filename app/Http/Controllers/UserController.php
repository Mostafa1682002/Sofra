<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware(['auth', 'auto_check_premission']);
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userRepository->index();
        return view('Users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->userRepository->create();
        return view('Users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required|unique:users,name",
            'email' => "required|email|unique:users,email",
            'roles' => "required",
            'password' => "required|confirmed"
        ]);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        $user = $this->userRepository->store($data);
        if ($user) {
            return redirect()->route('users.index')->with('success', 'تم اضافة مستخدم جديد بنجاح');
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
        $data = $this->userRepository->edit($id);
        return view('Users.edite', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => "required|unique:users,name,$id",
            'email' => "required|email|unique:users,email,$id",
            'roles' => "required",
            'password' => "confirmed"
        ]);


        $data = $request->except('password');
        if ($request->has('password') && !empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }

        $user = $this->userRepository->update($data, $id);
        if ($user) {
            return redirect()->back()->with('success', 'تم تحديث بيانات المستخدم بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = $this->userRepository->destroy($id);
        if ($user) {
            return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }
}