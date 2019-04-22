<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class userOTPmodel extends Model
{
    //
    public static function getUserOtp($userMobileNo){
        $userOtp = DB::table('userotp')
        ->select('UserOtpMobileNo','UserOtpCode','UserOtpAddedDate')
        ->where('UserOtpCodeIsVerified', 0)
        ->where('UserOtpMobileNo', $userMobileNo)
        ->get();      
           
           return $userOtp;
         
        }
}
