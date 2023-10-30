<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Models\PaymentType;

class PaymentTypeRepository implements BaseInterface
{
    public function index()
    {
        $payment_types = PaymentType::paginate(15);
        return $payment_types;
    }
    public function show($request)
    {
    }
    public function create()
    {
    }
    public function store($request)
    {
        $payment_types = PaymentType::create($request);
        return $payment_types;
    }
    public function edit($id)
    {
    }
    public function update($request, $id)
    {
        $payment_types = PaymentType::findOrFail($id)->update($request);
        return $payment_types;
    }

    public function destroy($id)
    {
        $payment_types = PaymentType::findOrFail($id)->delete();
        return $payment_types;
    }
}