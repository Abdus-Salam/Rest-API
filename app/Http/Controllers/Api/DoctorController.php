<?php

namespace App\Http\Controllers\Api;

use DateTime;
use DateTimezone;
use Validator;
use App\Doctor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorController extends Controller{


	/* 1. GET /values request 			 => Fetch all data from doctor table
	*  2. GET /values?keys=key1,key2.... => Fetch data by key
	* ==============================================
	* 
	*/

    public function index(Request $request){

    	// 2. GET /values?keys=key1,key2.... => Fetch data by key
    	
    	if($request->keys){ 
    		$explode = explode(',', $request->keys );
	    	$keys = '';
	    	foreach ($explode as $value) {
	    		$keys =  "'".trim($value)."'" . ',' . $keys;
	    	}
			// remove last character , from the keys 
			$keys = substr($keys, 0, -1);

			// test purpose
    		//$keys = "'key1', 'key2'"; 

    		$doctor = Doctor::readByKeys($keys);

    		if($doctor){
                    //
                    $isUpdated = Doctor::updateByKeys($keys);
                    return response()->json([
                    "success"   => true,
                    "message"   => 'Data fetch by keys successfully',
                    "data"      => $doctor
                ], 200);
                }else{
                    return response()->json([
                        "success"   => true,
                        "message"   => 'Data fetch by keys successfully',
                        "data"      => $doctor
                    ], 200);
                }
    	}else{
    		// no set keys to GET URL
    		// 1. GET /values request => Fetch all data from doctor table
            $isUpdated = Doctor::updateAllByTTL();
    		$doctor = Doctor::readAll();

    		return response()->json([
    			"success"   => true,
    			"message"	=> 'All data fetch successfully',
    			"data"		=> $doctor
    		], 200);
    	}
    }


    /* POST / values request
	* ==============================================
	* Store data to doctor table
	*/

    public function store(Request $request){
    	$validator = Validator::make($request->all(), [ // <---
            'key' => 'required',
            'value' => 'required'
        ]);

    	if ($validator->fails()){
    		return response()->json([
	    			"error"   => true,
	    			"message"	=> 'Data isn\'t added. Please check key\'s uniqueness',
	    			"data"		=> []
	    		], 500);
    	}
    		
    	
    	$doctor = new Doctor;

	    $doctor->_key = trim($request->key);
	    $doctor->value = trim($request->value);

       
         try {

            $saved = $doctor->save();
            return response()->json([
	    			"success"   => true,
	    			"message"	=> 'Data is added successfully',
	    			"data"		=> $doctor
	    		], 201);

        } catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1062'){
               return response()->json([
	    			"error"   => true,
	    			"message"	=> 'Data is not added successfully. Please check duplicate key',
	    			"data"		=> $doctor
	    		], 500);
            }
        }
    }

    public function update(Request $request){
    	$validator = Validator::make($request->all(), [ // <---
            'key' => 'required',
            'value' => 'required'
        ]);

    	if ($validator->fails()){
    		return response()->json([
	    			"error"   => true,
	    			"message"	=> 'Data isn\'t added. Please check key and value',
	    			"data"		=> []
	    		], 500);
    	}
    	
    	$doctor = Doctor::find($request->key);
        $doctor->value = trim($request->value);
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    	$doctor->TTL = $dt->format('Y-m-d H:i:s');
        $saved = $doctor->save();
     
        if($saved){
        		return response()->json([
	    			"success"   => true,
	    			"message"	=> 'Data is updated successfully',
	    			"data"		=> $doctor
	    		], 201);
        }else{
        	return response()->json([
	    			"error"   => true,
	    			"message"	=> 'Data is not added successfully',
	    			"data"		=> $doctor
	    		], 500);
        }
    }
}
