<?php

namespace App\Repositories;

use App\Interfaces\BaseInterface;
use App\Models\Client;

class ClientRepository implements BaseInterface
{
    public function index()
    {
        $clients = Client::paginate(20);
        return $clients;
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
        $client = Client::findOrFail($id);
        $client->update($request->only('active'));
        return $client;
    }
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $image = $client->image;
        $client->delete();
        return compact('client', 'image');
    }
}