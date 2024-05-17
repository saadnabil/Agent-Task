<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => __($this->gender),
            'image' => $this->image ?  url('storage/'.$this->image) : null,
            'countrydata' => new CountryResource($this->country) ,
            'role' => $this->roles->pluck('name'),
            'permissions' => $this->roles->first()->permissions->pluck('name'),
        ];
        if($this->token){
            $data['token'] = $this->token;
        };
        return $data;
    }
}
