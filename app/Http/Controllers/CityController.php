<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

use function App\Helpers\returnToApi;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
    }

    public function getCititesBasedOnState(Request $request)
    {
        try {
            if ($request->state_id) {
                $return_object = City::select('id', 'name')
                    ->where('state_id', $request->state_id)
                    ->orderBy('id')
                    ->get();
            } else {
                $return_object = City::select('id', 'name')
                    ->orderBy('id')
                    ->get();
            }

            return returnToApi('success', 'Cities list.', $return_object);
        } catch (\Exception $e) {
            return returnToApi('error', 'Failed to get data.' . ' ' . $e->getMessage());
        }
    }
}
