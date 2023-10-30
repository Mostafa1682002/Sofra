<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use App\Repositories\PaymentTypeRepository;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    protected $paymentTypeRepository;
    public function __construct(PaymentTypeRepository $paymentTypeRepository)
    {
        $this->middleware(['auth', 'auto_check_premission']);
        $this->paymentTypeRepository = $paymentTypeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment_types = $this->paymentTypeRepository->index();
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

        $payment_types = $this->paymentTypeRepository->store($request->all());
        if ($payment_types) {
            return  redirect()->back()->with('success', 'تم اضافه طريقة الدفع بنجاح');
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
            'name' => "required|unique:payment_types,name,$id"
        ]);
        $payment_types = $this->paymentTypeRepository->update($request->all(), $id);
        if ($payment_types) {
            return  redirect()->back()->with('success', 'تم تعديل طريقة الدفع بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment_types = $this->paymentTypeRepository->destroy($id);
        if ($payment_types) {
            return  redirect()->back()->with('success', 'تم حذف طريقة الدفع بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }
}