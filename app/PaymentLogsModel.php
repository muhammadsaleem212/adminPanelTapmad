<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PaymentLogsModel extends Model
{
    //
    protected $table = 'userpaymentlogs';
    public static function getPaymentLog($dateRange){
        $userPaymentLog = DB::table('userpaymentlogs')
        ->select('PaymentLogPlatform','PaymentLogUserId','PaymentLogOperatorId','PaymentLogProductId','PaymentLogMobileNo','PaymentLogMessage','PaymentLogAddedDate','PaymentLogUpdatedDate')
        ->orWhere('PaymentLogMessage',    $dateRange['UserPaymentMessage'])
        ->whereDate('PaymentLogAddedDate',$dateRange['PaymentLogAddedDate'])
        ->whereDate('PaymentLogAddedDate',$dateRange['PaymentLogAddedDate'])
        
        ->get();    
           
           return $userPaymentLog;
         
        }
        public static function getPaymentDefault($dateRange){
          $userPaymentLog = DB::table('userpaymentlogs')
          ->select('PaymentLogPlatform','PaymentLogUserId','PaymentLogOperatorId','PaymentLogProductId','PaymentLogMobileNo','PaymentLogMessage','PaymentLogAddedDate','PaymentLogUpdatedDate')
          ->whereDate('PaymentLogAddedDate',$dateRange['PaymentLogAddedDate'])
          ->whereDate('PaymentLogAddedDate',$dateRange['PaymentLogAddedDate'])
          
          ->get();    
             
             return $userPaymentLog;
           
          }
          public static function getPaymentLogMessage(){ 
            $userPaymentMessage = DB::table('userpaymentlogs')
           ->select('PaymentLogMessage')
           ->distinct()
           ->get();    
           return $userPaymentMessage;
            
           }
}
