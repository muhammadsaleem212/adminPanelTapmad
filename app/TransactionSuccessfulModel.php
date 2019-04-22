<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class TransactionSuccessfulModel extends Model
{
    //
    protected $table = 'userpayments';
    public static function getSuccessfulTransaction($dateRange){
          $userFailedPayment = DB::table('userpayments')
          ->select('UserPaymentPlatform','UserPaymentUserName','UserPaymentPackageType','UserPaymentStartDate','UserPaymentEndDate','UserPaymentMobileNumber','UserPaymentOperatorID','UserPaymentMessage','UserPaymentPackageName')
          ->orWhere('UserPaymentMessage',    $dateRange['UserPaymentMessage'])
          ->whereDate('UserPaymentStartDate',$dateRange['UserPaymentStartDate'])
          ->whereDate('UserPaymentStartDate',$dateRange['UserPaymentStartDate'])
          
          ->get();    
             
             return $userFailedPayment;
           
          }
          public static function getSuccessfulTransactionDefault($dateRange){
            $userFailedPayment = DB::table('userpayments')
            ->select('UserPaymentPlatform','UserPaymentUserName','UserPaymentPackageType','UserPaymentStartDate','UserPaymentEndDate','UserPaymentMobileNumber','UserPaymentOperatorID','UserPaymentMessage','UserPaymentPackageName')
            ->whereDate('UserPaymentStartDate',$dateRange['UserPaymentStartDate'])
            ->whereDate('UserPaymentStartDate',$dateRange['UserPaymentStartDate'])
            
            ->get();    
               
               return $userFailedPayment;
             
            }
      public static function getSuccessfulTransactionMessage(){ 
               $userFailedPaymentMessage = DB::table('userpayments')
              ->select('UserPaymentMessage')
              ->distinct()
              ->get();    
              return $userFailedPaymentMessage;
               
              }
}
