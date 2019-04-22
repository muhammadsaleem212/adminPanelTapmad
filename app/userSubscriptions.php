<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class userSubscriptions extends Model
{
    protected $table = 'usersubscriptions';
    //
    public static function getAllUserSubscription($date){
     $user = DB::table('usersubscriptions')
     ->leftJoin('user', 'user.UserId', '=', 'usersubscriptions.UserSubscriptionUserId')
     ->select('UserUsername','UserSubscriptionUserId','UserSubscriptionPackageId','UserSubscriptionExpiryDate','UserSubscriptionAddedDate','UserPackageCode','PackageName')
     ->whereDate('UserSubscriptionAddedDate', '=', date('Y-m-d'))
     ->orderBy('UserSubscriptionAddedDate','DESC')
     
     ->get();
    
    return $user;
  
   }
    public static function CheckSubscriptionNumber($mobileNum){
         $user = DB::table('UserSubscriptionUserId','UserSubscriptionPackageId','UserSubscriptionExpiryDate','UserSubscriptionAddedDate','UserPackageCode','PackageName')
        ->select('UserUsername','UserACR')
        ->where('UserUsername', $mobileNum)
        ->get();
        $arrResult = collect($user)->toArray();
        
        return $arrResult;
      
     }
     public static function getUserSubscription($mobileNum){
          $user = DB::table('user')
          ->leftJoin('usersubscriptions', 'usersubscriptions.UserSubscriptionUserId', '=', 'user.UserId')
         ->select('UserUsername','UserSubscriptionUserId','UserSubscriptionPackageId','UserSubscriptionExpiryDate','UserSubscriptionAddedDate','UserPackageCode','PackageName')
         ->where('UserUsername', $mobileNum)
         ->get();
         $arrResult = collect($user)->toArray();
         return $arrResult;
       
      }     
      public static function checkUser($user){
         $mobileNum = $user['UserUsername'];
         $user = DB::table('user')
        ->select('UserUsername')
        ->where('UserUsername', $mobileNum)
        ->get();
        $arrResult = collect($user)->toArray();
        return $arrResult;
      
     }
     public static function saveSuccessPayment($successPayment)
   {
    $ProductId = $successPayment['PaymentLogProductId'];   
    $successPayment['Version'] ="V1";
    $successPayment['Platform='] = "dcb";
    $successPayment['IsRecurring'] =1;
    $UserPaymentPackageName = userSubscriptions::getPackageNameByPackage($ProductId);
    $successPayment['UserPaymentStatus'] =1;
    $successPayment['SubcribtionType'] =1;
    $successPayment['Message'] ='Transaction-Successful';
    $subscriptionDays= userSubscriptions::getSubscriptionDaysByProduct($ProductId);
    $successPayment['subscriptionDays'] = $subscriptionDays;
    $SubscriptionByUserIdPackageCode =  userSubscriptions :: getSubscriptionByUserIdPackageCode($successPayment); 
    if($SubscriptionByUserIdPackageCode===1)
    {        
        userSubscriptions::updateUserSubscriptions($successPayment);
    }else{           
        userSubscriptions::insertUserSubscriptions($successPayment);
    }
    userSubscriptions::insertPaymentAndUpdateUserSystem($UserId,$Version,$Platform,$ProductId,$UserPaymentStatus,$IsRecurring,$TransID,$MSISDN,$OperatorID,$Message,$UserPaymentPackageName,$db);
    $obj['Transaction-Successful']="Transaction-Successful";
   }        
   public static function getPackageNameByPackage($TransPackage)
{   
   $packageName = DB::table('packages')
  ->select('PackageName')
  ->where('PackageProductId', $TransPackage)
  ->get();
   return $packageName;
}
public static function getSubscriptionDaysByProduct($TransPackage)
{
    if($TransPackage === '1007'){
            $subscriptionDays= 18;
            $UserPaymentPackageName="Premium";
        }else if ($TransPackage === '1005'){
            $subscriptionDays= 15;
            $UserPaymentPackageName="Movies";
        }else if ($TransPackage === '1178'){
            $subscriptionDays= 21;
            $UserPaymentPackageName="Premium + Movie";
        }
        else if ($TransPackage === '1177'){
            $subscriptionDays= 15;
            $UserPaymentPackageName="Movies";
        }
        else if ($TransPackage === '1176'){
            $subscriptionDays= 18;
            $UserPaymentPackageName="Premium";
        }
        else if($TransPackage === '1009'){
            $subscriptionDays= 21;
            $UserPaymentPackageName="Premium + Movie";
        }else if($TransPackage === '1008'){
            $TransPackage='1009';
            $subscriptionDays= 20;
            $UserPaymentPackageName="Premium + Movie";
        }else if($TransPackage === '1003'){
            $TransPackage='1009';
            $subscriptionDays= 19;
            $UserPaymentPackageName="Premium + Movie";
        }else if($TransPackage === '1004'){
            $TransPackage='1009';
            $subscriptionDays= 17;
            $UserPaymentPackageName="Premium + Movie";
        }
        
        return $subscriptionDays;
}
public static function getSubscriptionByUserIdPackageCode($userId,$productId)
{
    $userSubscription = DB::table('usersubscriptions')
   ->select('UserSubscriptionId')
   ->where('UserSubscriptionUserId', $userId)
   ->where('UserPackageCode', $productId)
   ->where('UserSubscriptionIsTempUser', 0)
   ->get();
    $arrResult = collect($userSubscription)->toArray();
    $resultArray = json_decode(json_encode($arrResult), true);
        

        if ($arrResult) {
            $results = 1;
            return $results;
        } else {
            $results = 0;
            return $results;
        }   
}
   public static function getUserPackageSubscription($userId)
   {
    $users = DB::select( DB::raw("SELECT     
    UserPackageCode As UserPackageType,   
    PackageName AS PackageName,   
    UserSubscriptionStartDate,
    UserSubscriptionExpiryDate,
    IF(IsSubscribe=0,1,0) AS IsExpiredPackage,
    IF(DATEDIFF(UserSubscriptionExpiryDate,UserSubscriptionStartDate)=11,1,0) AS IsBucketUser,
    IF(UserPackageCode=1009,1,0) AS AllInOne
    FROM usersubscriptions   WHERE UserSubscriptionUserId= '$userId'  AND UserSubscriptionIsTempUser=0 ORDER BY UserSubscriptionId DESC limit 0,2") );
            

     $arrResult = collect($users)->toArray();
     return $arrResult;
        
    }
    public static function saveSuccessfulPayment($userPaymentSuccess)
    {
      //  WHERE UserSubscriptionUserId = :userId,
        $userPaymentSuccess['UserPaymentVersion'] = 'V1';
        $userPaymentSuccess['UserPaymentPlatform']="dcb";
        $userPaymentSuccess['IsRecurring'] = 1;
        $userPaymentSuccess['UserPaymentStatus'] = 1;
        $userPaymentSuccess['SubcribtionType'] = 1;
        $userPaymentSuccess['SubcribtionType'] = 1;
        $userPaymentSuccess['UserPaymentMessage']='Transaction-Successful';
        $userPaymentSuccess['UserPaymentPackageName']=userSubscriptions::getPackageNameByPackage($ProductId,$db);
      
       
       
      $arrResult = collect($user)->toArray();
      return $arrResult;
         
     }
     public static function updateUserSubscriptions($userId,$productId,$subscriptionDays,$SubcribtionType)
{
     
    $PackageName = userSubscriptions::getPackageNameByPackage($productId);
    $subdays = date('Y-m-d H:i:s', time() + (86400*$subscriptionDays));
    $subscriptionWhere = array(
       'UserSubscriptionExpiryDate' => $subscriptionDays,
       'UserSubscriptionUserId'     => $userId,
       'UserSubscriptionIsTempUser' => 0
    );
    $userSubscriptionUpdate = array(
        'userId'           => $userId,
        'UserPackageCode'  => $productId,
        'SubcribtionType'  => $SubcribtionType,
        'totalDays'        => $subdays,
        'PackageName'      => $PackageName
    );

   
    $userSubscription = DB::table('usersubscriptions')
   
    ->where($subscriptionWhere)
    ->update($userSubscriptionUpdate)
    ->get();
     $arrResult = collect($userSubscription)->toArray();
     $SubcribtionID = DB::getPdo()->lastInsertId();
}
public static function  insertUserSubscriptions($UserId,$IncrementDays,$TransPackage,$SubcriptionType)
{
    $insertUserSubscriptions = DB::table('usersubscriptions')->insert(
        array(
               'UserSubscriptionUserId'              =>   $UserId, 
               'UserSubscriptionIsTempUser'          =>    0,
               'UserSubscriptionPackageId'           =>   10,
               'UserSubscriptionStartDate'           =>   date('Y-m-d H:i:s'),
               'UserSubscriptionExpiryDate'          =>   userSubscriptions::getIncrementDateWithCurrent($IncrementDays." days"),
               'UserSubscriptionMaxConcurrentConnections'   =>   6,
               'UserSubscriptionAutoRenew'          =>   0,
               'UserSubscriptionDetails'            =>   NULL,
               'UserPackageCode'                    =>   $TransPackage,
               'PackageName'                        =>   userSubscriptions::getSubscriptionDaysByProduct($TransPackage),
               'IsSubscribe'                        =>   1,
               'SubcribtionType'                    =>   $SubcriptionType
        )
   );
    $lastId = DB::getPdo()->lastInsertId();
}
public static function insertPaymentAndUpdateUserSystem($UserId,$Version,$Platform,$TransPackage,$UserPaymentStatus,$IsRecurring,$TransID,$MSISDN,$OperatorID,$Status,$UserPaymentPackageName)
{
//---------------------------insert into payment---------------------------------//    

    $userPayments = DB::table('userpayments')
   ->select('UserPaymentUserName,UserPaymentTransactionId,UserPaymentIP')
   ->where('UserPaymentTransactionId', $TransID)
   ->get();
    $resultArray = json_decode(json_encode($userPayments), true);
    if(empty($resultArray)){
//---------------------------insert into payment---------------------------------//    
    $insert = array(
        "UserPaymentVersion" => $Version,
        "UserPaymentPlatform" => $Platform,
        "UserPaymentUserName" => $UserId,
        "UserPaymentPackageType" => $TransPackage,
        "UserPaymentStatus" => $UserPaymentStatus,
        "UserPaymentIsRecurring" => $IsRecurring,
        "UserPaymentTransactionId" => $TransID,
        "UserPaymentIP" => '111.119.160.222',
        "UserPaymentMobileNumber" => $MSISDN,
        "UserPaymentOperatorID" => $OperatorID,
        "UserPaymentMessage" => $Status,
        "UserPaymentPackageName" => $UserPaymentPackageName,
    );
    $db->insert("userpayments", $insert);
//-----------------------------------update user information---------------------------//

    $subscriptionWhere = array(
        'UserId'     => $UserId
    );
    $userSubscriptionUpdate = array(
        "UserIsFree" => 0,
        "UserPackageType"       => $TransPackage,
        "UserActivePackageType" => $TransPackage,
        "UserPackageIsRecurring" => $IsRecurring,
    );


   $userSubscription = DB::table('usersubscriptions')
    ->where($subscriptionWhere)
    ->update($userSubscriptionUpdate)
    ->get();
        
     
    }
        
}
public static function getAndroidBucket($productID,$OperatorID)
{
    $Platform       = 'Android';
    $OperatorID     = $OperatorID;
    $productID      = $productID; 
    $userSubscriptionBucket = DB::table('dynamicbucket')
   ->select('BucketStatus')
   ->whereRaw('FIND_IN_SET(?,Platform)', [$Platform])
   ->whereRaw('FIND_IN_SET(?,ProductId)', [$productID])
   ->whereRaw('FIND_IN_SET(?,OperatorId)', [$OperatorID])
   ->get();
    $arrResult = collect($userSubscriptionBucket)->toArray();
    $resultArray = json_decode(json_encode($arrResult), true);
    $resultArray = $resultArray[0]['BucketStatus'];
    
        if ($arrResult) {
            $results = 1;
            return $results;
        } else {
            $results = 0;
            return $results;
        }   
}
public static function saveFailPaymentTranscation($failPaymentsArray)
{
    $productId = $failPaymentsArray['UserPaymentPackageType'];
    $failPaymentsArray['UserPaymentPackageName'] = userSubscriptions::getPackageNameByPackage($productId);
    $userPackageName = $failPaymentsArray['UserPaymentPackageName'];
    $userId = $failPaymentsArray['UserPaymentUserName'];
    $Version="V1";
    $Platform="dcb";
    $IsRecurring=1;
    $subscriptionDays=11;
    $UserPaymentStatus=0;
    $SubcribtionType=2;
    $MSISDN  = $failPaymentsArray['UserPaymentMobileNumber'];
    $transID = $failPaymentsArray['UserPaymentTransactionId'];
    $OperatorID = $failPaymentsArray['UserPaymentOperatorID'];
    $message='Transaction-Failed-Insufficient';
    $getSubscriptionByUserIdPackageCode = userSubscriptions::getSubscriptionByUserIdPackageCode($userId,$productId);
    if($getSubscriptionByUserIdPackageCode ===1){
    $updatreUserSubscriptions = userSubscriptions::updateUserSubscriptions($userId,$productId,$subscriptionDays,$SubcribtionType);
    }else{
      $insertUserSubscriptions =  userSubscriptions::insertUserSubscriptions($userId,$subscriptionDays,$productId,$SubcribtionType);
    }
    $insertFailPaymentAndUpdateUserSystem = userSubscriptions::insertFailPaymentAndUpdateUserSystem($userId,$Version,$Platform,$productId,$UserPaymentStatus,$IsRecurring,$transID,$MSISDN,$OperatorID,$message,$userPackageName);
    $saveFailTrialTransactions = userSubscriptions::saveFailTrialTransactions($Version,$Platform,$userId,$productId,$IsRecurring,$transID,$MSISDN,$OperatorID,$message);
    $obj['Transaction-Failed-Insufficient']="Bucket";
    }
//     public static function getUserPackageSubscription($user,$db)
// {
        
//         $results;
//         $sql = <<<STR
//                 SELECT     
                    
//                     UserPackageCode As UserPackageType,   
//                     PackageName AS PackageName,   
//                     UserSubscriptionStartDate,
//                     UserSubscriptionExpiryDate,
//                     IF(IsSubscribe=0,1,0) AS IsExpiredPackage,
//                     IF(DATEDIFF(UserSubscriptionExpiryDate,UserSubscriptionStartDate)=11,1,0) AS IsBucketUser,
//                     IF(UserPackageCode=1009,1,0) AS AllInOne
                
// FROM usersubscriptions                           

//                     WHERE UserSubscriptionUserId=:UserId
//                    AND UserSubscriptionIsTempUser=0 ORDER BY UserSubscriptionId DESC limit 0,2
// STR;
                    
//                     $bind = array(
//                         ":UserId" => $user
//                     );
//                     // print_r ( $bind );
//                     $results = $db->run($sql, $bind);	
//                     Format::formatResponseData($results);
//                     return $results;
        
//     }

public static function insertFailPaymentAndUpdateUserSystem($UserId,$Version,$Platform,$TransPackage,$UserPaymentStatus,$IsRecurring,$TransID,$MSISDN,$OperatorID,$Status,$UserPaymentPackageName)
{
//---------------------------insert into payment---------------------------------//  

$insertUserSubscriptions = DB::table('usersubscriptions')->insert(
    array(
           'UserPaymentVersion'                  =>   $Version, 
           'UserPaymentPlatform'                 =>   $Platform,
           'UserPaymentUserName'                 =>   $UserId,
           'UserPaymentPackageType'              =>   $TransPackage,
            'UserPaymentStatus'                  =>   $UserPaymentStatus,
           'UserPaymentIsRecurring'              =>   $IsRecurring,
           'UserPaymentTransactionId'            =>   $TransID,
           'UserPaymentTransactionId'            =>   0,
           'UserPaymentIP'                       =>   NULL,
           'UserPaymentMobileNumber'             =>   $MSISDN,
           'UserPaymentOperatorID'               =>   $OperatorID,
           'UserPaymentMessage'                  =>   $Status,
           'UserPaymentPackageName'              =>   $UserPaymentPackageName
    )
        );
//-----------------------------------update user information---------------------------//

    $subscriptionWhere = array(
        'UserId'     => $UserId
    );
    $userSubscriptionUpdate = array(
        "UserIsFree" => 0,
        "UserPackageType" => $TransPackage,
        "UserActivePackageType" => $TransPackage,
        "UserPackageIsRecurring" => $IsRecurring,
    );


    $userSubscription = DB::table('users')
    ->where($subscriptionWhere)
    ->update($userSubscriptionUpdate)
    ->get();
        
}

public static function getIncrementDateWithCurrent($subdays) {
    $timezone = date_default_timezone_get();
    $date = date_create($timezone);
    date_add($date, date_interval_create_from_date_string($subdays));

    return date_format($date, "Y-m-d H:i:s");
}
public static function saveFailTrialTransactions($Version,$Platform,$UserId,$ProductID,$IsRecurring,$TransID,$MSISDN,$OperatorID,$Message)
{
    $insertUserSubscriptions = DB::table('usersubscriptions')->insert(
        array(
               'TrialVersion'                   =>   $Version, 
               'TrialPlatform'                  =>   $Platform,
               'TrialUserId'                    =>   $UserId,
               'TrialProductId'                 =>   $ProductID,
               'TrialIsRecurring'               =>   $IsRecurring,
               'TrialTransactionId'             =>   $TransID,
               'TrialIP'                        =>   0,
               'TrialMobileNo'                  =>   $MSISDN,
               'TrialOperatorID'                =>   $OperatorID,
               'TrialMessage'                   =>   $Message
        )
            );
}

    
}
