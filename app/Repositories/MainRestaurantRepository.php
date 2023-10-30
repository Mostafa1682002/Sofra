<?php

namespace App\Repositories;

use App\Interfaces\MainRestaurantInterface;
use App\Mostafa\Status;

class MainRestaurantRepository implements MainRestaurantInterface
{
    public function products($request)
    {
        $products = $request->user()->products()->latest()->paginate(20);
        return $products;
    }
    public function createProduct($request)
    {
        $restaurant = auth('api_restaurant')->user();
        $product = $restaurant->products()->create($request);
        return $product;
    }

    public function showProduct($request, $id)
    {
        $product = $request->user()->products->where('id', $id)->first();
        return $product;
    }

    public function updateProduct($request, $id)
    {
        $product = $request->user()->products->where('id', $id)->first(); /////
        //new data
        $data = $request->except('image');
        if ($product) {
            if ($request->hasFile('image')) {
                $image_name = uniqid(5) . $request->file('image')->getClientOriginalName();
                $data['image'] = $image_name;
                $old_image = $product->image;
                unlink('./' . parse_url($old_image)['path']);
                $request->file('image')->storeAs('', $image_name, 'products');
            }
            $product->update($data);
        }
        return $product;
    }

    public function deleteProduct($request, $id)
    {
        $product = $request->user()->products->where('id', $id)->first();
        $image = $product->image;
        $product->delete();
        return compact('product', 'image');
    }


    public function offers($request)
    {
        $offers = $request->user()->offers()->latest()->paginate(20);
        return $offers;
    }
    public function createOffer($request)
    {
        $resturant = auth('api_restaurant')->user();
        $offer = $resturant->offers()->create($request);
        return $offer;
    }

    public function showOffer($request, $id)
    {
        $offer = $request->user()->offers->where('id', $id)->first();
        return $offer;
    }

    public function updateOffer($request, $id)
    {
        $offer = $request->user()->offers->where('id', $id)->first();
        //new data
        $data = $request->except('image');
        if ($offer) {
            if ($request->hasFile('image')) {
                $image_name = uniqid(5) . $request->file('image')->getClientOriginalName();
                $data['image'] = $image_name;

                $old_image = $offer->image;
                unlink('./' . parse_url($old_image)['path']);
                $request->file('image')->storeAs('', $image_name, 'offers');
            }
            $offer->update($data);
        }
        return $offer;
    }

    public function deleteOffer($request, $id)
    {
        $offer = $request->user()->offers->where('id', $id)->first();
        $image = $offer->image;
        $offer->delete();
        return compact('offer', 'image');
    }

    public function restaurantOrder($request)
    {
        $orders = $request->user()->orders()->where(function ($query) use ($request) {
            //طلبات جديده
            if ($request->has('status') && $request->status == Status::PENDING) {
                $query->where('status', Status::PENDING);
            }
            //طلبات حاليه
            if ($request->has('status') && $request->status == Status::ACCEPTED) {
                $query->where('status', Status::ACCEPTED);
            }
            //طلبات سابقه
            if ($request->has('status') && ($request->status == Status::DELEIVERED || $request->status == Status::CANCELED)) {
                $query->where('status', Status::CANCELED)->orWhere('status', Status::DELEIVERED);
            }
        })->with('products', 'client')->paginate(10);
        return $orders;
    }

    public function acceptOrder($request, $id)
    {
        $order = $request->user()->orders()->where('id', $id)->with('products', 'client')->first(); //
        if ($order) {
            $order->update(['status' => Status::ACCEPTED]);
            //Send Notification
            $client = $order->client;
            $order->notifications()->create([
                'title' => "تم قبول الطلب ",
                'content' => "تم قبول طلبك رقم " . $order->id,
                'notificationable_type' => get_class($client),
                'notificationable_id' => $client->id,
            ]);
            $token = $request->user()->token;
            if ($token) {
                $title = "تم قبول الطلب ";
                notifyByFirebase($title, $token, [
                    'content' => "تم قبول طلبك رقم " . $order->id,
                    'order_id' => $order->id
                ]);
            }
        }
        return $order;
    }
    public function rejectOrder($request, $id)
    {
        $order = $request->user()->orders()->where('id', $id)->with('products', 'client')->first();
        if ($order) {
            $order->update(['status' => Status::REJECTED]);
            //Send Notification
            $client = $order->client;
            $order->notifications()->create([
                'title' => "تم رفض الطلب ",
                'content' => "تم رفض طلبك رقم " . $order->id,
                'notificationable_type' => get_class($client),
                'notificationable_id' => $client->id,
            ]);
            $token = $request->user()->token;
            if ($token) {
                $title = "تم رفض الطلب ";
                notifyByFirebase($title, $token, [
                    'content' => "تم رفض طلبك رقم " . $order->id,
                    'order_id' => $order->id
                ]);
            }
        }
        return $order;
    }

    public function confirmOrder($request, $id)
    {
        $order = $request->user()->orders()->where('id', $id)->with('products', 'client')->first(); //
        if ($order) {
            if ($order->status == Status::ACCEPTED) {
                $order->update(['status' => Status::DELEIVERED]);
            }
        }
        return $order;
    }
    public function transaction($request)
    {
        $cost = $request->user()->orders()->sum('cost');
        $commission = $request->user()->orders()->sum('commission');
        $payments = $request->user()->transactions()->sum('amount');
        $rest = $commission - $payments;
        return compact('cost', 'commission', 'payments', 'rest');
    }
}