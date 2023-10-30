<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Models\Order;

class OrderRepository implements BaseInterface
{
    public function index()
    {
        $orders = Order::latest()->paginate(20);
        return $orders;
    }
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return $order;
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
    }
}