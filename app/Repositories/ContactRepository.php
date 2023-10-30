<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Models\Category;
use App\Models\Contact;

class ContactRepository implements BaseInterface
{
    public function index()
    {
        $contacts = Contact::orderBy('id', 'DESC')->paginate(15);
        return $contacts;
    }
    public function show($id)
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
        $contact = Contact::findOrFail($id)->delete();
        return $contact;
    }
}