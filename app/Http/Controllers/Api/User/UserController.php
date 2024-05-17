<?php

namespace App\Http\Controllers\Api\User;

use App\Exports\ExportAdmins;
use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ValidateAdminForm;
use App\Http\Requests\Api\User\UserFormValidation;
use App\Http\Resources\Api\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Admin;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */

    function __construct()
    {
         $this->middleware('permission:user-list', ['only' => ['index']]);
         $this->middleware('permission:user-create', ['only' => ['store']]);
         $this->middleware('permission:user-edit', ['only' => ['update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $users = User::latest();
        if(request()->has('search')){
            $users = $users->where(function($q){
                $q->where('name', 'like', '%'.request('search').'%')
                ->orwhere('email', 'like', '%'.request('search').'%')
                ->orwhere('phone', 'like', '%'.request('search').'%')
                ->orwhere('gender', 'like', '%'.request('search').'%');
            });
        }
        $users = $users->simplepaginate();
        return $this->sendResponse(resource_collection(UserResource::collection($users)));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormValidation $request)
    {
        $data = $request->validated();
        $role = $data['role'];
        unset($data['role']);
        unset($data['repassword']);
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $user->assignRole($role);
        return $this->sendResponse([]);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->sendResponse(new UserResource($user));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UserFormValidation $request, User $user)
    {
        $data = $request->validated();
        $role = $data['role'];
        unset($data['role']);
        unset($data['repassword']);
        if(isset($data['password'])){

            $data['password'] = bcrypt($data['password']);
        }
        unset($data['password']);
        $user->update($data);
        $user->roles()->detach();
        $user->assignRole($role);
        return $this->sendResponse([]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->sendResponse([]);
    }

}
