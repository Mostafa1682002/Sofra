<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->middleware(['auth', 'auto_check_premission']);
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryRepository->index();
        return view('Categories.index', compact('categories'));
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
            'name' => "required|unique:categories,name"
        ]);
        $category = $this->categoryRepository->store($request->all());
        if ($category) {
            return  redirect()->back()->with('success', 'تم اضافه القسم بنجاح');
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
            'name' => "required|unique:categories,name,$id"
        ]);

        $category = $this->categoryRepository->update($request->all(), $id);
        if ($category) {
            return  redirect()->back()->with('success', 'تم تعديل القسم بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->categoryRepository->destroy($id);
        if ($category) {
            return  redirect()->back()->with('success', 'تم حذف القسم بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }
}