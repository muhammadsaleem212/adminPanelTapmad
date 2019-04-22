<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class userPermission extends Model
{
    //
    
    protected $fillable = [
        'screen_id','user_role_id'
    ];
    protected $table = 'userPermission';

   public static function checkUserScreen($userScreen){
       $userScreenArray = $userScreen['userScreens'];
       $screens = DB::table('userscreens')
       ->where('userScreenName', $userScreenArray)
       ->get();
        $arrResult = collect($screens)->toArray();
       
       return $arrResult;
     
    }
    public static function checkUserPermission($userScreen){
        $screensID = $userScreen['userScreenID'];
        $userRoleID = $userScreen['userRoleID'];
        $screens = DB::table('userpermission')
        ->where('screen_id', $screensID)
        ->where('user_role_id', $userRoleID)
        ->get();
         $arrResult = collect($screens)->toArray();

        return $arrResult;
      
     }
}

