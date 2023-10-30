<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Repositories\OfferRepository;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    protected $offerRepository;
    public function __construct(OfferRepository $offerRepository)
    {
        $this->middleware(['auth', 'auto_check_premission']);
        $this->offerRepository = $offerRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = $this->offerRepository->index();
        return view('Offers.index', compact('offers'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $offer = $this->offerRepository->destroy($id);
        if ($offer) {
            if (isset($offer['image'])) {
                unlink("./" . parse_url($offer['image'])['path']);
            }
            return redirect()->back()->with('success', 'تم حذف العرض بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }
}