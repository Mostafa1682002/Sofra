<?php

namespace App\Repositories;

use App\Interfaces\MainRestaurantInterface;
use App\Mostafa\Status;

class MainRestaurantRepository implements MainRestaurantInterface
{
    public function createProduct($request)
    {
        $data = $request->except('image');
        $image_name = uniqid(5) . $request->file('image')->getClientOriginalName();
        $data['image'] = $image_name;

        $product = $request->user()->products()->create($data); ///////////

        $request->file('image')->storeAs('', $image_name, 'products');
        return apiResponse(200, 'Product Created Succssfuly', $product);
    }

    public function showProduct($request, $id)
    {
        $product = $request->user()->products->where('id', $id)->first();
        if ($product) {
            return apiResponse(200, 'success', $product);
        }
        return apiResponse(401, 'Product Not Found');
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
            return apiResponse(200, 'Product Updated Succssfuly', $product);
        }
        return apiResponse(401, 'Product Not Found');
    }

    public function deleteProduct($request, $id)
    {
        $product = $request->user()->products->where('id', $id)->first();
        if ($product) {
            unlink('./' . parse_url($product->image)['path']);
            $product->delete();
            return apiResponse(200, 'Product Deleted Succssfuly');
        }
        return apiResponse(401, 'Product Not Found');
    }

    public function createOffer($request)
    {
        $data = $request->except('image');
        $image_name = uniqid(5) . $request->file('image')->getClientOriginalName();
        $data['image'] = $image_name;

        $offer = $request->user()->offers()->create($data);
        $request->file('image')->storeAs('', $image_name, 'offers');
        return apiResponse(200, 'Offer Created Succssfuly', $offer);
    }

    public function showOffer($request, $id)
    {
        $offer = $request->user()->offers->where('id', $id)->first();
        if ($offer) {
            return apiResponse(200, 'success', $offer);
        }
        return apiResponse(401, 'Offer Not Found');
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
            return apiResponse(200, 'Offer Updated Succssfuly', $offer);
        }
        return apiResponse(401, 'Offer Not Found');
    }

    public function deleteOffer($request, $id)
    {
        $offer = $request->user()->offers->where('id', $id)->first();
        if ($offer) {
            unlink('./' . parse_url($offer->image)['path']);
            $offer->delete();
            return apiResponse(200, 'Offer Deleted Succssfuly');
        }
        return apiResponse(401, 'Offer Not Found');
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
        })->with('products', 'client')->paginate(10); /////
        return apiResponse(200, 'success', $orders);
    }
    public function acceptOrder($request, $id)
    {
        $order = $request->user()->orders()->where('id', $id)->with('products', 'client')->first(); //
        if (!$order) {
            return apiResponse(200, 'الطلب غير موجود');
        }
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

        return apiResponse(200, 'تم الموافقه علي الطلب', $order);
    }
    public function rejectOrder($request, $id)
    {
        $order = $request->user()->orders()->where('id', $id)->with('products', 'client')->first();
        if (!$order) {
            return apiResponse(200, 'الطلب غير موجود');
        }
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
        return apiResponse(200, 'تم  رفض  الطلب', $order);
    }
    public function confirmOrder($request, $id)
    {
        $order = $request->user()->orders()->where('id', $id)->with('products', 'client')->first(); //
        if (!$order) {
            return apiResponse(200, 'الطلب غير موجود');
        }

        if ($order->status != Status::ACCEPTED) {
            return apiResponse(200, 'لم يتم الموافقعه علي الطلب');
        }

        $order->update(['status' => Status::DELEIVERED]);
        return apiResponse(200, 'تم  تسليم الطلب', $order);
    }
    public function transaction($request)
    {
        $cost = $request->user()->orders()->sum('cost');
        $commission = $request->user()->orders()->sum('commission');
        $payments = $request->user()->transactions()->sum('amount');
        $rest = $commission - $payments;
        return apiResponse(200, 'success', compact('cost', 'commission', 'payments', 'rest'));
    }
}
