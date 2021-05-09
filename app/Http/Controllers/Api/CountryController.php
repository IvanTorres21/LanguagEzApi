<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    
    /**
     * Returns all country codes
     */
    public function index() {
        $countries = Country::all();
    }

    /**
     * Adds a new country code
     */
    public function store(Request $request) {
        if(!$request->user()->admin) {
            return response()->json([
                'status code' : 500,
                'message' : 'Unauthorized'
            ]);
        }
        $country = new Country;
        $country->code = $request->code;
        $country->name = $request->name;
        $country->save();
    }

    /**
     * Deletes a country code
     */
    public function delete(Request $request) {
        if(!$request->user()->admin) {
            return response()->json([
                'status code' : 500,
                'message' : 'Unauthorized'
            ]);
        }
        $country = Country::find($request->id);
        $country->delete();
    }
}
