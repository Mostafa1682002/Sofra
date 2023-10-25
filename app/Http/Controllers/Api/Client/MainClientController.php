<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Interfaces\MainClientInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainClientController extends Controller
{
    protected  $clientInterface;

    public function __construct(MainClientInterface $clientInterface)
    {
        $this->clientInterface = $clientInterface;
    }

    public function restaurants(Request $request)
    {
        return $this->clientInterface->restaurants($request);
    }



    public function restaurant($id)
    {
        return $this->clientInterface->restaurant($id);
    }



    public function newOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products.*.product_id' => "required|exists:products,id",
            'products.*.quantity' => "required",
            'address' => "required",
            'payment_type_id' => "required|exists:payment_types,id",
            'restaurant_id' => "required|exists:restaurants,id",
        ]);
        if ($validator->fails()) {
            return apiResponse(401, 'errors', $validator->errors());
        }
        return $this->clientInterface->newOrder($request);
    }




    public function myOrders(Request $request)
    {
        return $this->clientInterface->myOrders($request);
    }



    public function cancelOrder(Request $request, $id)
    {
        return $this->clientInterface->cancelOrder($request, $id);
    }


    public function confirmOrder(Request $request, $id)
    {
        return $this->clientInterface->confirmOrder($request, $id);
    }


    public function addReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'restaurant_id' => "required|exists:restaurants,id",
            'rate' => "required|in:1,2,3,4,5 else",
        ]);
        if ($validator->fails()) {
            return apiResponse(401, 'errors', $validator->errors());
        }
        return $this->clientInterface->addReview($request);
    }
}
