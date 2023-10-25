<?php

namespace App\Repositories;

use App\Interfaces\MainClientInterface;
use App\Models\City;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Setting;
use App\Mostafa\Status;

class MainClientRepository implements MainClientInterface
{
    public function restaurants($request)
    {
        $restaurants = Restaurant::where(function ($query) use ($request) {
            if ($request->has('city_id')) {
                $regoin_ids = City::findOrFail($request->city_id)->regoins->pluck('id');
                $query->whereIn('regoin_id', $regoin_ids);
            }
        })
            ->orWhere(function ($query) use ($request) {
                if ($request->has('name')) {
                    $query->where('name', 'like', '%' . $request->name . '%');
                }
            })
            ->paginate(10);
        return apiResponse(200, 'success', $restaurants);
    }

    public function restaurant($id)
    {
        $restaurant = Restaurant::find($id)->with(['products', 'clients'])->first();
        if (!$restaurant) {
            return apiResponse(200, 'Restaurant Is Not Found');
        }
        return apiResponse(200, 'success', $restaurant);
    }

    public function newOrder($request)
    {
        $restaurant = Restaurant::find($request->restaurant_id);
        if (!$restaurant) {
            return apiResponse(300, ' المطعم غير موجود');
        }
        if (!$restaurant->status) {
            return apiResponse(300, 'هذا المطعم غير مفتوح حاليا');
        }


        $cost = 0;
        $order = $request->user()->orders()->create([
            'notes' => $request->notes,
            'payment_type_id' => $request->payment_type_id,
            'address' => $request->address,
            'restaurant_id' => $restaurant->id,
        ]);


        foreach ($request->products as $product) {
            $price = Product::find($product['product_id'])->price;
            $add_pro = [
                $product['product_id'] => [
                    'quantity' => $product['quantity'],
                    'price' => $price,
                    'notes' => $product['notes'],
                ]
            ];
            $cost += $price * $product['quantity'];
            $order->products()->attach($add_pro);
        }

        if ($cost >= $restaurant->minimum_order) {
            $delivary_cost = $restaurant->delivary_cost;
            $total_cost = $cost + $delivary_cost;
            $commission_rate = Setting::first()->commission_rate;
            $commission = $cost * ($commission_rate / 100);

            $order->update([
                'cost' => $cost,
                'delivary_cost' => $delivary_cost,
                'total_cost' => $total_cost,
                'commission' => $commission,
            ]);
            //Send Notification
            $notification = $order->notifications()->create([
                'title' => "لديك طلب جديد",
                'content' => "لديك طلب جديد من العميل " . $request->user()->name,
                'notificationable_type' => get_class($restaurant),
                'notificationable_id' => $restaurant->id,
            ]);
            $token = $request->user()->token;
            if ($token) {
                $title = "لديك طلب جديد";
                notifyByFirebase($title, $token, [
                    'content' => "لديك طلب جديد من العميل " . $request->user()->name,
                    'order_id' => $order->id
                ]);
            }

            return apiResponse(200, 'The order has been requested successfully', [
                'order' => $order->load('products'),
                'notifications' => $notification
            ]);
        } else {
            return apiResponse(301, 'لابد ان يكون الطلب قيمته اكبر من ' . $restaurant->minimum_order);
        }
    }

    public function myOrders($request)
    {
        $orders = $request->user()->orders()
            ->where(function ($query) use ($request) {
                //طلبات حاليه
                if ($request->has('status') && $request->status == Status::PENDING) {
                    $query->where('status', Status::PENDING);
                }
                //طلبات سابقه
                if ($request->has('status') && ($request->status == Status::DELEIVERED || $request->status == Status::CANCELED)) {
                    $query->where('status', Status::CANCELED)->orWhere('status', Status::DELEIVERED);
                }
            })->with('products')->latest()->paginate(10);
        return apiResponse(200, 'success', $orders);
    }

    public function cancelOrder($request, $id)
    {
        $order = $request->user()->orders->where('id', $id)->first();

        if (!$order) {
            return apiResponse(200, 'الطلب غير موجود');
        }

        if ($order->status != Status::ACCEPTED) {
            return apiResponse(200, 'لم يتم الموافقه علي الطلب');
        }

        $order->update(['status' => Status::CANCELED]);
        $restaurant = $order->restaurant;
        //Send Notification
        $order->notifications()->create([
            'title' => "تم رفض الطلب ",
            'content' => "تم رفض الطلب  رقم $order->id من العميل" . $request->user()->name,
            'notificationable_type' => get_class($restaurant),
            'notificationable_id' => $restaurant->id,
        ]);
        $token = $request->user()->token;
        if ($token) {
            $title = "تم رفض الطلب ";
            notifyByFirebase($title, $token, [
                'content' => "تم رفض الطلب  رقم $order->id من العميل" . $request->user()->name,
                'order_id' => $order->id
            ]);
        }
        return apiResponse(200, 'تم الغاء الطلب بنجاح');
    }

    public function confirmOrder($request, $id)
    {
        $order = $request->user()->orders->where('id', $id)->first();
        if (!$order) {
            return apiResponse(200, 'الطلب غير موجود');
        }

        if ($order->status != Status::ACCEPTED) {
            return apiResponse(200, 'لم يتم الموافقه علي الطلب');
        }

        $order->update(['confirmed_by_client' => 1]);
        return apiResponse(200, 'تم تاكيد استلام الطلب بنجاح');
    }

    public function addReview($request)
    {
        $request->user()->restaurants()->attach([
            $request->restaurant_id => [
                'rate' => $request->rate,
                'comment' =>  $request->comment ?? 'NULL',
            ]
        ]);
        return apiResponse(200, 'تم الارسال بنجاح');
    }
}
