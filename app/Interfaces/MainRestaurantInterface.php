<?php

namespace App\Interfaces;

interface MainRestaurantInterface
{
    public function products($request);
    public function createProduct($request);
    public function showProduct($request, $id);
    public function updateProduct($request, $id);
    public function deleteProduct($request, $id);
    public function offers($request);
    public function createOffer($request);
    public function showOffer($request, $id);
    public function updateOffer($request, $id);
    public function deleteOffer($request, $id);
    public function restaurantOrder($request);
    public function acceptOrder($request, $id);
    public function rejectOrder($request, $id);
    public function confirmOrder($request, $id);
    public function transaction($request);
}