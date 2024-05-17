<?php
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\LoginUserValidation;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

use App\Services\User\AuthService;

class AuthController extends Controller
{
    use ApiResponseTrait;
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginUserValidation $request){
        $data = $request->validated();
        return $this->authService->login($data);
    }


    public function logout(){
        Auth::logout();
        return $this->sendResponse([]);
    }

}



