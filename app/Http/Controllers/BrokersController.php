<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrokersResource;
use App\Models\Broker;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BrokersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Broker::all();
        return BrokersResource::collection(Broker::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $postFields = $this->validateBroker();
        $broker = Broker::create($postFields);
        return new BrokersResource($broker);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Broker $broker)
    {
        return new BrokersResource($broker);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Broker $broker)
    {
        $postFields = $this->validateBroker($broker);
        $broker->update($postFields);

        return new BrokersResource($broker);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Broker $broker)
    {
        $broker->delete();
        return response()->json([
            'success' => true,
            'message' => 'Broker has been deleted from database'
        ]);
    }

    protected function validateBroker(Broker $broker = null)
    {
        $broker ??= new Broker();
        $is_required = $broker->exists ? 'sometimes' : 'required';

        return request()->validate([
            'name' => [$is_required, Rule::unique('brokers')->ignore($broker), 'max:255'],
            'address' => [$is_required, 'max:255'],
            'city' => [$is_required],
            'zip_code' => [$is_required],
            'phone_number' => [$is_required, 'numeric', 'digits:10'],
            'logo_path' => [$is_required]
        ]);
    }
}
