<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Interfaces\MainRestaurantInterface;
use App\Mostafa\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainResturantController extends Controller
{

    protected $restaurantInterface;
    public function __construct(MainRestaurantInterface $restaurantInterface)
    {
        $this->restaurantInterface = $restaurantInterface;
    }


    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required",
            'description' => "required",
            'price' => "required",
            'price_offer' => "required",
            'processing_time' => "required|integer",
            'image' => "required|image",
        ]);

        if ($validator->fails()) {
            return apiResponse(401, 'errors', $validator->errors());
        }
        return $this->restaurantInterface->createProduct($request);
    }

    public function showProduct(Request $request, $id)
    {
        return $this->restaurantInterface->showProduct($request, $id);
    }

    public function updateProduct(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required",
            'description' => "required",
            'price' => "required",
            'price_offer' => "required",
            'processing_time' => "required|integer",
            'image' => "image",
        ]);

        if ($validator->fails()) {
            return apiResponse(401, 'errors', $validator->errors());
        }
        return $this->restaurantInterface->updateProduct($request, $id);
    }


    public function deleteProduct(Request $request, $id)
    {
        return $this->restaurantInterface->deleteProduct($request, $id);
    }


    public function createOffer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required",
            'discription' => "required",
            'start_time' => "required|date",
            'end_time' => "required|date",
            'image' => "required|image",
        ]);

        if ($validator->fails()) {
            return apiResponse(401, 'errors', $validator->errors());
        }
        return $this->restaurantInterface->createOffer($request);
    }


    public function showOffer(Request $request, $id)
    {
        return $this->restaurantInterface->showOffer($request, $id);
    }

    public function updateOffer(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required",
            'discription' => "required",
            'start_time' => "required|date",
            'end_time' => "required|date",
            'image' => "image",
        ]);

        if ($validator->fails()) {
            return apiResponse(401, 'errors', $validator->errors());
        }
        return $this->restaurantInterface->updateOffer($request, $id);
    }


    public function deleteOffer(Request $request, $id)
    {
        return $this->restaurantInterface->deleteOffer($request, $id);
    }


    public function restaurantOrder(Request $request)
    {
        return $this->restaurantInterface->restaurantOrder($request);
    }



    public function acceptOrder(Request $request, $id)
    {
        return $this->restaurantInterface->acceptOrder($request, $id);
    }

    public function rejectOrder(Request $request, $id)
    {
        return $this->restaurantInterface->rejectOrder($request, $id);
    }


    public function confirmOrder(Request $request, $id)
    {
        return $this->restaurantInterface->confirmOrder($request, $id);
    }


    public function transaction(Request $request)
    {
        return $this->restaurantInterface->transaction($request);
    }
}
