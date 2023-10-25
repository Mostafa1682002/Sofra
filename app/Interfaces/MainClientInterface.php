<?php

namespace App\Interfaces;

interface MainClientInterface
{
    public function restaurants($request);

    public function restaurant($id);

    public function newOrder($request);

    public function myOrders($request);

    public function cancelOrder($request, $id);

    public function confirmOrder($request, $id);

    public function addReview($request);
}
