<?php

namespace App\Http\Controllers\API;

use App\Enums\AddressType;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\API\CustomerListResource;
use App\Http\Resources\API\CustomerResource;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerAddress;


class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$shipping = CustomerAddress::query()->where('id','=',$id);
        $countries = Country::query()->orderBy('name')->get();
        foreach ($countries as $country){
            $country->community = json_decode($country->community);
        }

        //$currentCountry =  Country::query()->where('code' ,'=',$shipping->country_code);

        return response($countries);
    }
}
