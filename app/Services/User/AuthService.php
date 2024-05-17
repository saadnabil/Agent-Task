<?php
namespace App\Services\User;
use App\Http\Resources\Api\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService{
    use ApiResponseTrait;

    public function register(array $data)
    {
        if(!isset($data['otp'])){
            $code = generate_otp_function();
            create_new_otp($data['email'], $code);
            return $this->sendResponse(['code' => $code]);
        }
        $otp = Otp::where(['email' => $data['email'], 'code' => $data['otp']])->first();
        if(!$otp){
            return $this->sendResponse(['error' => __('messages.Verification code is not correct')],'fail','404');
        }
        $data['password'] = Hash::make($data['password']);
        unset($data['otp']);
        unset($data['confirmpassword']);
        $user = User::create($data);
        $user['token'] = Auth::login($user);
        $otp->delete();
        return $this->sendResponse(new UserResource($user));
    }

    public function login(array $data){
        $token = Auth::attempt(['email' => $data['email'], 'password' => $data['password']]);
        if (!$token) {
            return $this->sendResponse(['error' => __('messages.Invalid credentials. Please make sure you are registered.')] , 'fail' , 404);
        }
        $user = Auth::user();
        $user->load('country');
        $user['token'] = $token;
        return $this->sendResponse(new UserResource($user));
    }

}

