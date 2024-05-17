<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\FeatureFormValidation;
use App\Http\Resources\Api\FeatureResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Feature;

class FeaturesController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        $this->middleware('permission:feature-list', ['only' => ['index']]);
        $this->middleware('permission:feature-show', ['only' => ['show']]);
        $this->middleware('permission:feature-create', ['only' => ['store']]);
        $this->middleware('permission:feature-edit', ['only' => ['update']]);
        $this->middleware('permission:feature-delete', ['only' => ['destroy']]);
        $this->middleware('permission:feature-delete', ['only' => ['approve']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $features = Feature::with('creator','approved')->latest();
        if(request()->has('search')){
            $features = $features->where(function($q){

                $q->where('name', 'like', '%'.request('search').'%')
                ->orwhere('description', 'like', '%'.request('search').'%')

                ->orwhereHas('creator', function($q){
                     $q->where('name',  'like', '%'.request('search').'%')
                      ->orWhere('email',  'like', '%'.request('search').'%')
                      ->orWhere('gender', 'like', '%'.request('search').'%')
                      ->orWhere('phone', 'like', '%'.request('search').'%' );
                })

                ->orwhereHas('approved', function($q){
                    $q->where('name', 'like', '%'.request('search').'%')
                     ->orWhere('email',  'like', '%'.request('search').'%')
                     ->orWhere('gender','like', '%'.request('search').'%' )
                     ->orWhere('phone', 'like', '%'.request('search').'%' );
               });
            });
        }
        $features =  $features->simplePaginate();
        return $this->sendResponse(resource_collection(FeatureResource::collection($features)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeatureFormValidation $request)
    {
        $data = $request->validated();
        $feature = Feature::create($data);
        return $this->sendResponse(new FeatureResource($feature));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        return $this->sendResponse(new FeatureResource($feature));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FeatureFormValidation $request, Feature $feature)
    {
        $data = $request->validated();
        $feature->update($data);
        return $this->sendResponse([]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        $feature->delete();
        return $this->sendResponse([]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Feature $feature)
    {
        $feature->update([
            'status' => 1,
        ]);
        return $this->sendResponse([]);
    }

}
