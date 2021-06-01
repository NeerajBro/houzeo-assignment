<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Log;

class Property_details_api extends Controller
{
    public function getPropertyDetails()
    {

        $output = array();

        $output['status_code'] = 400;
        $output['msg'] = 'failure';


    	$propertyDetails = DB::select(DB::raw("SELECT PI.house_id,
											   CONCAT(street ,' ',city ,' ',state ,' ',county ,' ',zip) as 'address',
											   AT.id as 'taskID', AT.title as 'taskTitle',
											   AT.updated_at
											   FROM property_info PI 
											   INNER JOIN property_location  PL  
											   ON PI.house_id = PL.house_id
											   INNER JOIN assigned_tasks AT
											   ON AT.house_id = PI.house_id"));
        Log::info('Property Data',array('Data' => $propertyDetails));
        
        if(count($propertyDetails) > 0)
        {
            $output['status_code'] = 200;
            $output['msg'] = 'success';
            $output['data'] = $propertyDetails;

        }
    	

        return $output;

    }

    public function form_validation()
    {
        return view('form_validation');
    }
}
