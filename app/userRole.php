<?php

namespace App;

use App\userRole;
use DB;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class userRole extends Model
{
    //
    
    protected $fillable = [
        'userRolesName'
    ];
    protected $table = 'userRoles';

   public static function checkUserRole($userRole){
       $userRoleArray = $userRole['userRoles'];
       $roles = DB::table('userroles')
       ->where('userRolesName', $userRoleArray)
       ->get();
        $arrResult = collect($roles)->toArray();
       
       return $arrResult;
     
    }
    public static function checkUserPermission($userArray){
        $userRoleID = $userArray['user_role_id'];
       
        $screenName = $userArray['controllerName'];
        $screenResult   = userRole :: getScreenID($screenName);
        $screenArray = json_decode( json_encode($screenResult), true);
        $screenID  = $screenArray[0]['id'];
        $checkUserPermission = DB::table('userpermission')
        ->where('screen_id', $screenID)
        ->where('user_role_id', $userRoleID)
        ->get();
         $arrResult = collect($checkUserPermission)->toArray();

        return $arrResult;
      
     }
     public static function getScreenID($screenName){
        
        $screenID = DB::table('userscreens')
        ->where('userScreenName', $screenName)
        ->get();
    
        return $screenID;
      
     }
}
