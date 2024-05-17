<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'birthdate' => $this->birthdate,
            'balance' => __($this->balance),
            'countrydata' => new CountryResource($this->country) ,
            'image' => $this->image ?  url('storage/'.$this->image) : null,
        ];
        return $data;
    }
}
