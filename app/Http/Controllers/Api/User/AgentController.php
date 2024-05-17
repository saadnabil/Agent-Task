<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AgentFormValidation;
use App\Http\Resources\Api\AgentResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Agent;

class AgentController extends Controller
{
    use ApiResponseTrait;


    public function __construct()
    {
        $this->middleware('permission:agent-list', ['only' => ['index']]);
        $this->middleware('permission:agent-show', ['only' => ['show']]);
        $this->middleware('permission:agent-create', ['only' => ['store']]);
        $this->middleware('permission:agent-edit', ['only' => ['update']]);
        $this->middleware('permission:agent-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $agents = Agent::with('country')->latest();
        if(request()->has('search')){
            $agents = $agents->where(function($q){
                $q->where('firstname', 'like', '%'.request('search').'%')
                ->orwhere('lastname', 'like', '%'.request('search').'%')
                ->orwhere('email', 'like', '%'.request('search').'%')
                ->orwhere('phone', 'like', '%'.request('search').'%')
                ->orwhere('role', 'like', '%'.request('search').'%')
                ->orwhere('birthdate', 'like', '%'.request('search').'%')
                ->orwhere('balance', 'like', '%'.request('search').'%');
            });
        }
        if(request()->has('country')){
            $agents = $agents->whereHas('country', function($q){
                $q->where('id', request('country'));
            });
        }
        $agents =   $agents->simplepaginate();
        return $this->sendResponse(resource_collection(AgentResource::collection($agents)));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgentFormValidation $request)
    {
        $data = $request->validated();
        $agent = Agent::create($data);
        return $this->sendResponse(new AgentResource($agent));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Agent $agent)
    {
        return $this->sendResponse(new AgentResource($agent));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AgentFormValidation $request, Agent $agent)
    {
        $data = $request->validated();
        $agent->update($data);
        return $this->sendResponse([]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        $agent->delete();
        return $this->sendResponse([]);
    }
}
