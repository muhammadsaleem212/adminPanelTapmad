<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Auth;

class CreateUser extends Model
{
    //
    protected $fillable = [
        'UserUsername','UserPassword','UserPackageType','UserIsFree','UserIsActive','UserAddedDate','UserCountryCode','UserIPAddress'
    ];
    protected $table = 'user';
    protected $guarded = ['remember_token'];

    public static function checkUser($mobileNum){
        $user = DB::table('user')
       ->select('UserId','UserUsername','UserACR')
       ->where('UserUsername', $mobileNum)
       ->get();
       $arrResult = collect($user)->toArray();
       
       return $arrResult;
     
    }
}
