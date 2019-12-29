<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model{
    protected $primaryKey = '_key';

    public $incrementing = false;

    // Read only name => key and address => value from Doctor table
    public static function readAll(){
    	return Doctor::select('_key', 'value')->get();
    }

    // Read by keys
    public static function readByKeys($key){
    	return DB::select("select _key, value from doctors where _key in ($key)");
    }

    // Update by keys
    public static function updateByKeys($key){
        return DB::select("update doctors set ttl=".DB::raw('CURRENT_TIMESTAMP')." where _key in ($key)");
    }

    public static function updateAllByTTL(){
        return DB::select("update doctors set ttl=".DB::raw('CURRENT_TIMESTAMP'));
    }
    

    
}
