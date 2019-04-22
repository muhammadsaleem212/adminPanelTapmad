<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class dynamicOffer extends Model
{
    //
    protected $fillable = [
       'title','description','startDate','expiryDate','promoCode','packageCode','isBucket','image'
    ];
    protected $table = 'dynamicoffers';
    public static function getPackageType(){
         $packageType = DB::table('packages')
        ->select('PackageId','PackageName','PackageProductId')
        ->where('isnewpackage',1)
        ->get(); 
           
           return $packageType;
         
        }
}
