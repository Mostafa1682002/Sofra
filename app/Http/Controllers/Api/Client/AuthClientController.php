<?php

namespace App\Http\Controllers\Api\Client;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ResetPasswprd;
use App\Models\Client;
use App\Models\Token;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthClientController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required|unique:clients,name",
            'email' => "required|email|unique:clients,email",
            'password' => "required|min:5|confirmed",
            'phone' => "required|unique:clients,phone",
            'regoin_id' => "required|exists:regoins,id",
            'image' => "required|image",
        ]);

        if ($validator->fails()) {
            return apiResponse(401, 'errors', $validator->errors());
        }

        $image_name = uniqid(5) . $request->file('image')->getClientOriginalName();
        $data = $request->except('image');
        $data['image'] = $image_name;

        $data['password'] = bcrypt($request->password);
        $data['api_token'] = Str::random(100);
        $client = Client::create($data);

        $request->file('image')->storeAs('', $image_name, 'clients');

        return apiResponse(200, 'success', [
            'api_token' => $client->api_token,
            'client' => $client,
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

        $client = Client::where('email', $request->email)->first();
        if ($client) {
            if (Hash::check($request->password, $client->password)) {
                return apiResponse(200, 'login success', [
                    'api_token' => $client->api_token,
                    'client' => $client,
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

        $client = Client::where('email', $request->email)->first();
        if ($client) {
            $code = rand(111111, 999999);
            $client->update(['code' => $code]);
            Mail::to($client)->send(new ResetPasswprd($code));
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

        $client = Client::where('code', $request->code)->first();
        if ($client) {
            $client->update([
                'password' => bcrypt($request->password),
                'api_token' => Str::random(100),
            ]);
            return apiResponse(200, 'The password has been successfully recovered', [
                'api_token' => $client->api_token,
                'client' => $client,
            ]);
        }
        return apiResponse(401, 'Invalid Code');
    }




    public function profile()
    {
        return apiResponse(200, 'success', auth('api_client')->user());
    }
    public function  updateProfile(Request $request)
    {
        $client = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => "required|unique:clients,name,$client->id",
            'email' => "required|email|unique:clients,email,$client->id",
            'password' => "confirmed",
            'phone' => "required|unique:clients,phone,$client->id",
            'regoin_id' => "required|exists:regoins,id",
            'image' => "image",
        ]);

        if ($validator->fails()) {
            return apiResponse(401, 'errors', $validator->errors());
        }

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $image_name = uniqid(5) . $request->file('image')->getClientOriginalName();
            $data['image'] = $image_name;
            unlink("./" . parse_url($client->image)['path']);
            $request->file('image')->storeAs('', $image_name, 'clients');
        }

        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $client->update($data);
        return apiResponse(200, 'update profile success', [
            'api_token' => $client->api_token,
            'client' => $client,
        ]);
    }








    public function registerToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => "required",
            'type' => "required|in:ios,android",
            // 'tokenable_type' => "required",
            // 'tokenable_id' => "required"
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
