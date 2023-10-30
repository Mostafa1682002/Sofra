<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $contactRepository;
    public function __construct(ContactRepository $contactRepository)
    {
        $this->middleware(['auth', 'auto_check_premission']);
        $this->contactRepository = $contactRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = $this->contactRepository->index();
        return view('Contacts.index', compact('contacts'));
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
        $contact = $this->contactRepository->destroy($id);
        if ($contact) {
            return redirect()->back()->with('success', 'تم حذف الرساله بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }
}