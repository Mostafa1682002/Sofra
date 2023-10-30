<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    protected $restaurantRepoitory;
    public function __construct(RestaurantRepository $restaurantRepoitory)
    {
        $this->middleware(['auth', 'auto_check_premission']);
        $this->restaurantRepoitory = $restaurantRepoitory;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = $this->restaurantRepoitory->index();
        return view('Restaurants.index', compact('restaurants'));
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
            'active' => "required|boolean"
        ]);

        $restaurant = $this->restaurantRepoitory->update($request->only('active'), $id);
        if ($restaurant) {
            return redirect()->back()->with('success', 'تم نعديل حالة تفعيل المطعم بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $restaurant = $this->restaurantRepoitory->destroy($id);
        if ($restaurant) {
            if (isset($restaurant['image'])) {
                unlink("./" . parse_url($restaurant['image'])['path']);
            }
            return redirect()->back()->with('success', 'تم حذف المطعم بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }
}