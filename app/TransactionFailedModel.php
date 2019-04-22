<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class TransactionFailedModel extends Model
{
    //
    protected $table = 'userfailpayments';

    public static function getFailedTransaction($dateRange){
      //  $dateFrom       = $dateRange['startDate'];
     //   $dateTo         = $dateRange['expiryDate']; 
        // if($dateRange['UserPaymentMessage']){
        // $PaymentMessage = $dateRange['UserPaymentMessage'];  
        // } 
        $userFailedPayment = DB::table('userfailpayments')
        ->select('UserPaymentPlatform','UserPaymentUserName','UserPaymentPackageType','UserPaymentStartDate','UserPaymentEndDate','UserPaymentMobileNumber','UserPaymentOperatorID','UserPaymentMessage','UserPaymentPackageName')
       
        ->orWhere('UserPaymentMessage', $dateRange['UserPaymentMessage'])
        ->whereDate('UserPaymentStartDate',$dateRange['UserPaymentStartDate'])
        ->whereDate('UserPaymentStartDate',$dateRange['UserPaymentStartDate'])
        
        ->get();    
           
           return $userFailedPayment;
         
        }
    public static function getFailedTransactionMesage(){ 
             $userFailedPaymentMessage = DB::table('userfailpayments')
            ->select('UserPaymentMessage')
            ->distinct()
            ->get();    
            return $userFailedPaymentMessage;
             
            }
}
