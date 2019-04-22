<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\userRole;
use DB;
use Auth;
use Illuminate\Http\Request;

class userPromoCodes extends Model
{
    //
    protected $fillable = [
        'UserMobileNumber','PromoCode','PackageCode','SubscriptionDays','IsUsed','IsExpire','PromoStartDate','PromoExpireDate','PromoCodeCount','IsPromoCodeValid'
    ];
    protected $table = 'userpromocodes';
    public static function getPromoCodeID($id){
        $promoCodeId = $id;
        $promoCode = DB::table('userpromocodes')
        ->where('PromoCodeId', $promoCodeId)
        ->get();
     
        return $promoCode;
      
     }
}
