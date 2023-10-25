<?php

namespace App\Http\Controllers\Api\Restaurant;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ResetPasswprd;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthRestaurantController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required|unique:restaurants,name",
            'email' => "required|email|unique:restaurants,email",
            'category_id' => "required|exists:categories,id|array",
            'password' => "required|min:5|confirmed",
            'phone' => "required|unique:restaurants,phone",
            'regoin_id' => "required|exists:regoins,id",
            'minimum_order' => "required",
            'delivary_cost' => "required",
            'whatsapp' => "required",
            'image' => "required|image",
        ]);

        if ($validator->fails()) {
            return apiResponse(401, 'errors', $validator->errors());
        }
        $data = $request->except('image');
        $image_name = uniqid(5) . $request->file('image')->getClientOriginalName();
        $data['image'] = $image_name;
        $data['password'] = bcrypt($request->password);
        $data['api_token'] = Str::random(100);
        $restaurant = Restaurant::create($data);
        $category_ids =  $request->category_id;
        $restaurant->categories()->attach($category_ids);
        $request->file('image')->storeAs('', $image_name, 'restaurants');
        return apiResponse(200, 'success', [
            'api_token' => $restaurant->api_token,
            'restaurant' => $restaurant->load('categories'),
        ]);
    }



    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => "required|email",
            'password' => "required",
        ]);

        if ($validator->fails()) {
            return apiResponse(401, 'errors', $validator->errors());
        }

        $restaurant = Restaurant::where('email', $request->email)->where('active', 1)->first();
        if ($restaurant) {
            if (Hash::check($request->password, $restaurant->password)) {
                return apiResponse(200, 'login success', [
                    'api_token' => $restaurant->api_token,
                    'restaurant' => $restaurant,
                ]);
            }
        }
        return apiResponse(401, 'Invalid Data');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => "required|email",
        ]);

        if ($validator->fails()) {
            return apiResponse(401, 'errors', $validator->errors());
        }

        $restaurant = Restaurant::where('email', $request->email)->where('active', 1)->first();
        if ($restaurant) {
            $code = rand(111111, 999999);
            $restaurant->update(['code' => $code]);
            Mail::to($restaurant)->send(new ResetPasswprd($code));
            return apiResponse(200, 'Send Message To Email  ,Please Check Your Email');
        }
        return apiResponse(401, 'Invalid Email');
    }



    public function newPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => "required",
            'password' => "required|min:5|confirmed",
        ]);

        if ($validator->fails()) {
            return apiResponse(401, 'errors', $validator->errors());
        }

        $restaurant = Restaurant::where('code', $request->code)->first();
        if ($restaurant) {
            $restaurant->update([
                'password' => bcrypt($request->password),
                'api_token' => Str::random(100),
            ]);
            return apiResponse(200, 'The password has been successfully recovered', [
                'api_token' => $restaurant->api_token,
                'restaurant' => $restaurant,
            ]);
        }
        return apiResponse(401, 'Invalid Code');
    }


    public function profile(Request $request)
    {
        $restaurant = Restaurant::where('id', $request->user()->id)->with('categories')->first();
        return apiResponse(200, 'success', $restaurant);
    }


    public function  updateProfile(Request $request)
    {
        $restaurant = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => "required|unique:restaurants,name,$restaurant->id",
            'email' => "required|email|unique:restaurants,email,$restaurant->id",
            'password' => "confirmed",
            'phone' => "required|unique:restaurants,phone,$restaurant->id",
            'regoin_id' => "required|exists:regoins,id",
            'minimum_order' => "required",
            'delivary_cost' => "required",
            'whatsapp' => "required",
            'image' => "image",
            'status' => "required|boolean",
            'category_id' => "required|exists:categories,id|array",
        ]);

        if ($validator->fails()) {
            return apiResponse(401, 'errors', $validator->errors());
        }

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $image_name = uniqid(5) . $request->file('image')->getClientOriginalName();
            $data['image'] = $image_name;
            unlink("./" . parse_url($restaurant->image)['path']);
            $request->file('image')->storeAs('', $image_name, 'restaurants');
        }

        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $category_ids =  $request->category_id;
        $restaurant->categories()->sync($category_ids);

        $restaurant->update($data);
        return apiResponse(200, 'update profile success', [
            'api_token' => $restaurant->api_token,
            'restaurant' => $restaurant,
        ]);
    }



    public function registerToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => "required",
            'type' => "required|in:ios,android",
        ]);

        if ($validator->fails()) {
            return apiResponse(401, $validator->errors());
        }

        $request->user()->token()->delete();
        $request->user()->token()->create([
            'token' => $request->token,
            'type' => $request->type,
            'tokenable_type' => get_class($request->user()),
            'tokenable_id' => $request->user()->id
        ]);
        return apiResponse(201, 'تم التسجيل بنجاح');
    }

    public function removeToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => "required",
        ]);

        if ($validator->fails()) {
            return apiResponse(401, $validator->errors());
        }
        $request->user()->token()->delete();
        return apiResponse(201, 'تم الحذف بنجاح');
    }
}
