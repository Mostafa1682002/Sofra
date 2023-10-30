<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Interfaces\MainClientInterface;
use App\Mostafa\Status;
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
        $restaurants = $this->clientInterface->restaurants($request);
        return apiResponse(200, 'success', $restaurants);
    }


    public function restaurant($id)
    {
        $restaurant = $this->clientInterface->restaurant($id);
        if (!$restaurant) {
            return apiResponse(200, 'Restaurant Is Not Found');
        }
        return apiResponse(200, 'success', $restaurant);
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
        $orders = $this->clientInterface->myOrders($request);
        return apiResponse(200, 'success', $orders);
    }



    public function cancelOrder(Request $request, $id)
    {
        $order = $this->clientInterface->cancelOrder($request, $id);
        return 1;
    }


    public function confirmOrder(Request $request, $id)
    {
        $order = $this->clientInterface->confirmOrder($request, $id);
        if ($order) {
            if ($order->status == Status::ACCEPTED) {
                return apiResponse(200, 'تم تاكيد استلام الطلب بنجاح');
            }
            return apiResponse(200, 'لم يتم الموافقه علي الطلب');
        }
        return apiResponse(200, 'الطلب غير موجود');
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
        $review = $this->clientInterface->addReview($request);
        if ($review) {
            return apiResponse(200, 'تم الارسال بنجاح');
        }
        return apiResponse(200, "حدث خطأ");
    }
}