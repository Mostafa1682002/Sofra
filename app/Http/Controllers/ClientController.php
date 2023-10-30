<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $clientRepository;
    public function __construct(ClientRepository $clientRepository)
    {
        $this->middleware(['auth', 'auto_check_premission']);
        $this->clientRepository = $clientRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = $this->clientRepository->index();
        return view('Clients.index', compact('clients'));
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'active' => "required|boolean"
        ]);

        $client = $this->clientRepository->update($request->all(), $id);
        if ($client) {
            return redirect()->back()->with('success', 'تم تحديث حاله العميل بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = $this->clientRepository->destroy($id);
        if ($client) {
            if (isset($client['image'])) {
                unlink("./" . parse_url($client['image'])['path']);
            }
            return redirect()->back()->with('success', 'تم حذف العميل بنجاح');
        }
        return  redirect()->back()->with('error', 'حدث خطأ');
    }
}