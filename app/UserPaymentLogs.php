<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class UserPaymentLogs extends Model
{
    //
    protected $fillable = [
        'PaymentLogStatus','PaymentLogVersion','PaymentLogPlatform','PaymentLogUserId','PaymentLogProductId',
        'PaymentLogTransactionType','PaymentLogOperatorId','PaymentLogMobileNo','PaymentLogReferenceId',
        'PaymentLogMessage','PaymentLogIP'
    ];
    protected $table = 'userpaymentlogs';

    public static function checkUserPayment($userId){
    $userName =        $userId['UserUserName'];
    $userPackageCode = $userId['UserPackageType'];     
    $userPayment = DB::table('usersubscriptions')
    ->select('UserPackageCode','SubcribtionType AS UserSubscriptionIsExpired')
    ->where('UserPackageCode', $userPackageCode)
    ->where('UserSubscriptionUserId', $userName)
    ->where('UserSubscriptionIsTempUser', 0)
    ->get();      
    $arrResult = collect($userPayment)->toArray();
       
       return $arrResult;
     
    }
}
