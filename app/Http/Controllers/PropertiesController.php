<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertiesResource;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PropertiesResource::collection(Property::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateProerties();
        $property = Property::create([
            'broker_id' => $request->broker_id,
            'address' => $request->address,
            'listing_type' => $request->listing_type,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'description' => $request->description,
            'build_year' => $request->build_year
        ]);

        $property->characteristic()->create([
            'property_id' => $property->id,
            'price' => $request->price,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'sqft' => $request->sqft,
            'price_sqft' => $request->price_sqft,
            'property_type' => $request->property_type,
            'status' => $request->status
        ]);

        return new PropertiesResource($property);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        return new PropertiesResource($property);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        $property->update($request->only([
            'broker_id', 'address', 'listing_type', 'city', 'zip_code', 'description', 'build_year'
        ]));
        $property->characteristic->where('property_id', $property->id)->update($request->only([
            'price', 'bedrooms', 'bathrooms', 'sqft', 'price_sqft', 'property_type', 'status'
        ]));
        return new PropertiesResource($property);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return response()->json([
            'success' => true,
            'message' => 'Property has been deleted from database'
        ]);
    }

    protected function validateProerties(Property $property = null)
    {
        $property ??= new Property();

        return request()->validate([
            'address' => ['required', 'max:255'],
            'listing_type' => ['required'],
            'city' => ['required'],
            'zip_code' => ['required', 'numeric'],
            'description' => ['required'],
            'build_year' => ['required'],
            'price' => ['required'],
            'bedrooms' => ['required'],
            'bathrooms' => ['required'],
            'sqft' => ['required'],
            'price_sqft' => ['required'],
            'property_type' => ['required'],
            'status' => ['required'],
        ]);
    }
}
