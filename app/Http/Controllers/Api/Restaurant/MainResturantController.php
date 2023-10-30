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

    public function products(Request $request)
    {
        $products = $this->restaurantInterface->products($request);
        return apiResponse(200, 'تم', $products);
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

        $data = $request->except('image');
        $image_name = uniqid(5) . $request->file('image')->getClientOriginalName();
        $data['image'] = $image_name;

        $product = $this->restaurantInterface->createProduct($data);
        $request->file('image')->storeAs('', $image_name, 'products');
        return apiResponse(200, 'تم اضافة المنتج بنجاح', $product);
    }

    public function showProduct(Request $request, $id)
    {
        $product = $this->restaurantInterface->showProduct($request, $id);
        if ($product) {
            return apiResponse(200, 'success', $product);
        }
        return apiResponse(401, 'Product Not Found');
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
        $product = $this->restaurantInterface->updateProduct($request, $id);
        if ($product) {
            return apiResponse(200, 'تم تعديل المنتج بنجاح', $product);
        }
        return apiResponse(401, 'المنتج غير موجود');
    }


    public function deleteProduct(Request $request, $id)
    {
        $product = $this->restaurantInterface->deleteProduct($request, $id);
        if ($product) {
            unlink('./' . parse_url($product['image'])['path']);
            return apiResponse(200, 'تم حذف المنتج بنجاح');
        }
        return apiResponse(401, 'المنتج غير موجود');
    }


    public function offers(Request $request)
    {
        $offers = $this->restaurantInterface->offers($request);
        return apiResponse(200, 'تم', $offers);
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

        $data = $request->except('image');
        $image_name = uniqid(5) . $request->file('image')->getClientOriginalName();
        $data['image'] = $image_name;

        $offer = $this->restaurantInterface->createOffer($data);
        if ($offer) {
            $request->file('image')->storeAs('', $image_name, 'offers');
            return apiResponse(200, 'تم اضافة العرض بنجاح', $offer);
        }
        return apiResponse(401, 'حدث خطأ');
    }


    public function showOffer(Request $request, $id)
    {
        $offer = $this->restaurantInterface->showOffer($request, $id);
        if ($offer) {
            return apiResponse(200, 'success', $offer);
        }
        return apiResponse(401, 'Offer Not Found');
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

        $offer = $this->restaurantInterface->updateOffer($request, $id);
        if ($offer) {
            return apiResponse(200, 'Offer Updated Succssfuly', $offer);
        }
        return apiResponse(401, 'Offer Not Found');
    }


    public function deleteOffer(Request $request, $id)
    {
        $offer = $this->restaurantInterface->deleteOffer($request, $id);
        if ($offer) {
            unlink('./' . parse_url($offer['image'])['path']);
            return apiResponse(200, 'Offer Deleted Succssfuly');
        }
        return apiResponse(401, 'Offer Not Found');
    }


    public function restaurantOrder(Request $request)
    {

        $orders = $this->restaurantInterface->restaurantOrder($request);
        return apiResponse(200, 'success', $orders);
    }



    public function acceptOrder(Request $request, $id)
    {
        $order = $this->restaurantInterface->acceptOrder($request, $id);
        if ($order) {
            return apiResponse(200, 'تم الموافقه علي الطلب', $order);
        }
        return apiResponse(200, 'الطلب غير موجود');
    }

    public function rejectOrder(Request $request, $id)
    {
        $order = $this->restaurantInterface->rejectOrder($request, $id);
        if ($order) {
            return apiResponse(200, 'تم  رفض  الطلب', $order);
        }
        return apiResponse(200, 'الطلب غير موجود');
    }


    public function confirmOrder(Request $request, $id)
    {
        $order = $this->restaurantInterface->confirmOrder($request, $id);
        if ($order) {
            if ($order->status == Status::PENDING) {
                return apiResponse(200, 'لم يتم الموافقعه علي الطلب');
            }
            return apiResponse(200, 'تم  تسليم الطلب', $order);
        }
        return apiResponse(200, 'الطلب غير موجود');
    }


    public function transaction(Request $request)
    {
        $data = $this->restaurantInterface->transaction($request);
        return apiResponse(200, 'success', $data);
    }
}
