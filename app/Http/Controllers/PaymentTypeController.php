<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auto_check_premission']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment_types = PaymentType::paginate(15);
        return view('Payments.index', compact('payment_types'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => "required|unique:payment_types,name"
        ]);

        PaymentType::create($request->all());
        return  redirect()->back()->with('success', 'تم اضافه طريقة الدفع بنجاح');
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
            'name' => "required|unique:payment_types,name,$id"
        ]);

        PaymentType::findOrFail($id)->update($request->all());
        return  redirect()->back()->with('success', 'تم تعديل طريقة الدفع بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PaymentType::findOrFail($id)->delete();
        return  redirect()->back()->with('success', 'تم حذف طريقة الدفع بنجاح');
    }
}
