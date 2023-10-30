<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Contact;
use App\Models\Offer;
use App\Models\Regoin;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{

    public function categories()
    {
        $categories = Category::all();
        return apiResponse(200, 'success', $categories);
    }

    public function cities()
    {
        $cities = City::all();
        return apiResponse(200, 'success', $cities);
    }
    public function regoins()
    {
        $regoins = Regoin::all();
        return apiResponse(200, 'success', $regoins);
    }

    public function contact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required",
            'email' => "required|email",
            'phone' => "required",
            'message' => "required",
            'type' => "required|in:complaint,suggestion,enquiry",
        ]);
        if ($validator->fails()) {
            return apiResponse(401, 'errors', $validator->errors());
        }
        Contact::create($request->all());
        return apiResponse(200, 'تم الارسال بنجاح');
    }


    public function offers()
    {
        $offers = Offer::whereDate('end_time', '>=', now())->paginate(10);
        return apiResponse(200, 'success', $offers);
    }

    public function settings()
    {
        $settings = Setting::first();
        return apiResponse(200, 'success', $settings);
    }
}