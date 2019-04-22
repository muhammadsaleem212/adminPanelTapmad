<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class BucketUsersModel extends Model
{
    //
    protected $table = 'usersubscriptions';
    public static function getBucketUsers($dateRange){
        $BucketUsers = DB::table('usersubscriptions')
        ->join('userfailpayments', 'userfailpayments.UserPaymentUserName', '=', 'usersubscriptions.UserSubscriptionUserId')
        ->select('userfailpayments.UserPaymentMessage','usersubscriptions.UserSubscriptionUserId','usersubscriptions.UserSubscriptionPackageId','usersubscriptions.UserSubscriptionStartDate','usersubscriptions.UserSubscriptionExpiryDate','usersubscriptions.UserPackageCode','usersubscriptions.PackageName','usersubscriptions.UserSubscriptionAddedDate')
        ->where('UserPaymentMessage', 'Transaction-Failed-Insufficient')
        ->where('SubcribtionType', 2)
        ->whereDate('UserSubscriptionStartDate',$dateRange['UserSubscriptionStartDate'])
        ->whereDate('UserSubscriptionExpiryDate',$dateRange['UserSubscriptionExpiryDate'])
        
        ->get();    
           
           return $BucketUsers;
         
        }
        public static function getBucketDefault($dateRange){
        //    print_r($dateRange); exit;
            $BucketUsers = DB::table('usersubscriptions')
            ->join('userfailpayments', 'userfailpayments.UserPaymentUserName', '=', 'usersubscriptions.UserSubscriptionUserId')
            ->select('userfailpayments.UserPaymentMessage','usersubscriptions.UserSubscriptionUserId','usersubscriptions.UserSubscriptionPackageId','usersubscriptions.UserSubscriptionStartDate','usersubscriptions.UserSubscriptionExpiryDate','usersubscriptions.UserPackageCode','usersubscriptions.PackageName','usersubscriptions.UserSubscriptionAddedDate')
            ->where('UserPaymentMessage', 'Transaction-Failed-Insufficient')
            ->where('SubcribtionType', 2)
            ->whereDate('UserSubscriptionStartDate',$dateRange['UserSubscriptionStartDate'])
            ->whereDate('UserSubscriptionStartDate',$dateRange['UserSubscriptionExpiryDate']) 
            ->get();    
               return $BucketUsers;
             
            }
            public static function getBucketUsersMessage(){ 
                $BucketUsersMessage = DB::table('userfailpayments')
               ->select('UserPaymentMessage')
               ->distinct()
               ->get();    
               return $BucketUsersMessage;
                
               }
}
