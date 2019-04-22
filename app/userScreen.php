<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class userScreen extends Model
{
    //
    
    protected $fillable = [
        'userScreenName','screenDisplayName','screenParentID'
    ];
    protected $table = 'userScreens';

   public static function checkUserScreen($userScreen){
       $userScreenArray = $userScreen['userScreenName'];
       $screens = DB::table('userscreens')
       ->where('userScreenName', $userScreenArray)
       ->get();
        $arrResult = collect($screens)->toArray();
       
       return $arrResult;
     
    }
    public static function getUsersScreens($userScreen){
        $userRoleID = $userScreen['user_role_id'];
        $screens = DB::table('userpermission')
        ->leftJoin('userscreens', 'userscreens.id', '=', 'userpermission.screen_id')
        ->leftJoin('userroles', 'userroles.id', '=',  'userpermission.user_role_id')
        ->select('userScreenName','userRolesName','screenDisplayName','screenParentID','screen_id','user_role_id')
        ->where('user_role_id', $userRoleID)
        ->get();
         $arrResult = collect($screens)->toArray();
        
        return $arrResult;
      
     }
    //  public static function getParentScreens($parentArray){
    //      $userRoleID = $parentArray['user_role_id'];
    //      $screenParentID = $parentArray['screenParentID'];
    //      $parentScreen = DB::table('userscreens')
    //     ->leftJoin('userroles', 'userroles.id', '=', 'userscreens.screenParentID')
    //     ->leftJoin('userpermission', 'userpermission.user_role_id', '=',  'userscreens.screenParentID')
    //     ->select('userScreenName','userRolesName','screenDisplayName','screenParentID','screen_id','user_role_id')
    //     ->where('user_role_id', $userRoleID)
    //     ->where('screenParentID', $screenParentID)
    //     ->get();
    //     //  DB::enableQueryLog();
    //      $arrResult = collect($parentScreen)->toArray();

        
    //     return $arrResult;
      
    //  }
     public static function getParentScreen($userRoleID){
        $parentScreen = DB::table('userpermission')
       ->leftJoin('userroles', 'userroles.id', '=', 'userpermission.user_role_id')
       ->leftJoin('userscreens', 'userscreens.id', '=',  'userpermission.screen_id')
       ->select('userScreenName','userRolesName','screenDisplayName','screenParentID','screen_id','user_role_id')
       ->where('user_role_id', $userRoleID)
       ->where('screenParentID', 0)
       ->get();
       //  DB::enableQueryLog();
      //  $jsonResult = json_encode($parentScreen);

       
       return $parentScreen;
     
    }
    public static function getAllParentScreen(){
        $allParentScreen = DB::table('userscreens')
       ->select('userScreenName','screenDisplayName','screenParentID','id')
       ->where('screenParentID', 0)
       ->get();
       //  DB::enableQueryLog();
      //  $jsonResult = json_encode($parentScreen);

       
       return $allParentScreen;
     
    }
    public static function getChildScreen($user){
        $userRoleID = $user['userRoleID'];
        $screenID   = $user['screenID'];
        $childScreen = DB::table('userpermission')
       ->leftJoin('userroles', 'userroles.id', '=', 'userpermission.user_role_id')
       ->leftJoin('userscreens', 'userscreens.id', '=',  'userpermission.screen_id')
       ->select('userScreenName','userRolesName','screenDisplayName','screenParentID','screen_id','user_role_id')
       ->where('user_role_id', $userRoleID)
       ->where('screenParentID', $screenID)
       ->get();
       //  DB::enableQueryLog();
      //  $jsonResult = json_encode($parentScreen);

       
       return $childScreen;
     
    }
}
