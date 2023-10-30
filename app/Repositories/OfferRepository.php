<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Models\Offer;

class OfferRepository implements BaseInterface
{
    public function index()
    {
        $offers = Offer::orderBy('id', 'DESC')->paginate(20);
        return $offers;
    }
    public function show($request)
    {
    }
    public function create()
    {
    }
    public function store($request)
    {
    }
    public function edit($id)
    {
    }
    public function update($request, $id)
    {
    }

    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        $image = $offer->image;
        $offer->delete();
        return compact('offer', 'image');
    }
}