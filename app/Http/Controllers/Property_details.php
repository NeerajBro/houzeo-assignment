<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DateTime;

class Property_details extends Controller
{
    public function index()
    {
        return view('property_listing');
    }

    public function form_validation()
    {
        return view('form_validation');
    }

    public function submitForm(Request $request)
    {


    	//default 10 year validation setup
    	Validator::extend('olderThan', function($attribute, $value, $parameters)
		{
		    $minAge = ( ! empty($parameters)) ? (int) $parameters[0] : 10;
		    return (new DateTime)->diff(new DateTime($value))->y >= $minAge;

		},'Minimum age required is greather than 15 years');

		$customMessages = [
        'required' => 'The :attribute field is required.',
    ];


    	//Validate inputs
        $this->validate($request, [
            'full_name'      => 'required|min:4|alpha',
            'dob'    => 'required|date|olderThan:15',
        ],$customMessages);

        if($request->has('phone_number'))
        {
        	if($request->input('phone_number'))
        	{
        		$this->validate($request, [
		            'phone_number'      => 'numeric|digits:10'
		        ]);
        	}
        }

    	

    }
}
