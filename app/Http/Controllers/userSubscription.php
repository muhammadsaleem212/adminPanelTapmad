<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\userPromoCodes;
use App\userSubscriptions;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp\Client;
use App\userRole;
use App\User;
use Config;
use App\CreateUser;
use App\UserPaymentLogs;
use App\Http\Requests;
use DB;
use Auth;
use Session;
use DateTime;


class userSubscription extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            $userArray = $this->user->toArray();
            $routeArray = app('request')->route()->getAction();
            $controllerAction = class_basename($routeArray['controller']);
            list($controller, $action) = explode('@', $controllerAction);
            $userArray['controllerName'] = $controller;
            $checkUserPermission = userRole::checkUserPermission($userArray);
            if($checkUserPermission){
            return $next($request);
            }else{
                return redirect('dashboard');
            }
        });
    }
    public function index()
    { 
    //     $API_URL = 'https://jsonplaceholder.typicode.com/todos/1';

    //     $response = file_get_contents($API_URL);
    //     $content = json_decode($response);
    //     print_r($content); exit;
    //     $client = new Client();
    //     $res = $client->request('GET', 'http://app.tapmad.com/api/getTapmadLossTranscation/11.4.2019');
    //    echo "<pre>";
    //     print_r($res); exit;
    //     $result= $res->getBody();
    //     dd($result); exit;
        $date = date('Y-m-d');
        $userSubscription = usersubscriptions::getAllUserSubscription($date);
        return view('userSubscription/index',['userSubscription' => $userSubscription]);
    }
    public function create()
    {
        return view('userSubscription/create');
    }
    public function store(Request $request)
    {
        ini_set('max_execution_time', 300);
        $userSubscription = $request->all();
        $validate =  $this->validate($request, [
            'subscriptionNumber'    =>  'required|min:11',
            'packageCode'           =>  'required|max:4',
        ]);
        // $userMobileNum = $userSubscription['subscriptionNumber'];
        // $userMobileNum = ltrim($userMobileNum, "0");
        // $userMobileNum = substr_replace($userMobileNum, 'T', 0, 0);           
        $user['UserUsername'] = ltrim(filter_var(isset($userSubscription['subscriptionNumber']) ? $userSubscription['subscriptionNumber'] : NULL, FILTER_SANITIZE_STRING), '0');
        $user['UserUsername'] = ltrim($user['UserUsername'], '+92');       
        $user['UserPassword'] = md5('TAPMAD999');
        $currentDate = new DateTime();
        $user['UserLastLoginAt'] = $currentDate->format('Y-m-d H:i:s');
        $user['UserAddedDate']   = $currentDate->format('Y-m-d H:i:s');
        $user['UserIsFree'] = '1';
        $user['UserIsActive'] = '1';
        $user['UserCountryCode'] = 'PK';
        $user['UserIPAddress'] = $request->ip();
        $user['UserProfileMobile'] = filter_var(isset($userSubscription['subscriptionNumber']) ? $userSubscription['subscriptionNumber'] : NULL, FILTER_SANITIZE_STRING);
        $user['UserProfilePlatform'] = filter_var(isset($userSubscription['Platform']) ?$userSubscription['Platform']  : NULL, FILTER_SANITIZE_STRING);
        $user['UserProfilePicture'] = NULL; 
        $user['UserPackageType'] = $userSubscription['packageCode']; 
        $userMobileNum = $userSubscription['subscriptionNumber'];
        $userMobileNum = ltrim($userMobileNum, "0");
        $userMobileNum = substr_replace($userMobileNum, 'T', 0, 0);    
        $user['UserUsername'] = $userMobileNum;
        $checkUser = userSubscriptions::checkUser($user);
        if(!$checkUser){
        $newUser = CreateUser::create([
                'UserUsername'       => $user['UserUsername'],
                'UserPassword'       => $user['UserPassword'],
                'UserPackageType'    => $user['UserPackageType'],
                'UserIsFree'         => $user['UserIsFree'],
                'UserIsActive'       => $user['UserIsActive'],
                'UserAddedDate'      => $user['UserAddedDate'],
                'UserCountryCode'    => $user['UserCountryCode'],
                'UserIPAddress'      => $user['UserIPAddress'],
            ]);
           
            $lastInserteduserId = DB::getPdo()->lastInsertId();
        if (isset($userSubscription['subscriptionNumber'])) {
            $userSubscription['subscriptionNumber'] = filter_var($userSubscription['subscriptionNumber'], FILTER_SANITIZE_STRING);
            $userSubscription['subscriptionNumber'] = ltrim($userSubscription['subscriptionNumber'], '0');
            $userSubscription['subscriptionNumber'] = ltrim($userSubscription['subscriptionNumber'], '+92');
            }
                $OperatorPrefixes = array(
                    'Mobilink' => array(
                        "300",
                        "301",
                        "302",
                        "303",
                        "304",
                        "305",
                        "306",
                        "307",
                        "308",
                        "309"
                    ),
                    'Telenor' => array(
                        "340",
                        "341",
                        "342",
                        "343",
                        "344",
                        "345",
                        "346",
                        "347",
                        "348",
                        "349"
                    ),
                    'Zong' => array(
                        "310",
                        "311",
                        "312",
                        "313",
                        "314",
                        "315",
                        "316",
                        "317",
                        "318",
                    ),
                    'Warid' => array(
                        "320",
                        "321",
                        "322",
                        "323",
                        "324",
                        "325",
                        "326",
                        "327",
                        "328",
                        "329",
                    )
                );
                if (in_array(substr($userSubscription['subscriptionNumber'], 0, 3), $OperatorPrefixes['Mobilink'])) {
                    $subscription['OperatorId'] = 100001;
                } else if (in_array(substr($userSubscription['subscriptionNumber'], 0, 3), $OperatorPrefixes['Telenor'])) {
                    $subscription['OperatorId'] = 100002;
                } else if (in_array(substr($userSubscription['subscriptionNumber'], 0, 3), $OperatorPrefixes['Zong'])) {
                    $subscription['OperatorId'] = 100003;
                } else {
                    return redirect('userSubscription');
                    $log->info('E_NO_OPERATOR : OPERATOR NOT SUPPORTED');
                    return General::getResponse($response->write(ErrorObject::getUserErrorObject(Message::getMessage('E_NO_OPERATOR'))));
                }
                $subscription['UserIP']           = $user['UserIPAddress'];
                $subscription['ProductId']        = $user['UserPackageType'];
                $subscription['MobileNo']         = $userSubscription['subscriptionNumber'];
                $subscription['Platform']         = 'androidnew';
                $subscription['Version']          = 'V1';
                $subscription['Language']         = 'en';
                $subscription['TransactionType']  = 1;
                
              $paymentLog = userPaymentLogs::create([
                    'PaymentLogStatus'            => 0,
                    'PaymentLogVersion'           => $subscription['Version'],
                    'PaymentLogPlatform'          => $subscription['Platform'],
                    'PaymentLogUserId'            => $lastInserteduserId,
                    'PaymentLogProductId'         => $subscription['ProductId'],
                    'PaymentLogOperatorId'        => $subscription['OperatorId'],
                    'PaymentLogMobileNo'          => $subscription['MobileNo'] ,
                    'PaymentLogMessage'           => null,
                    "PaymentLogIP"                => $user['UserIPAddress']
                ]);
                $paymentId = DB::getPdo()->lastInsertId();
                $userId['UserUserName'] = $newUser['UserUserName'];
                $userId['UserPackageType'] = $subscription['ProductId'];
                $lastUserId = DB::getPdo()->lastInsertId();
                $userPaymentCheck = userSubscriptions:: getUserSubscription($userId);
                if($userPaymentCheck){
                if (($userPaymentCheck[0]['UserSubscriptionIsExpired']===1 || $userPaymentCheck[0]['UserSubscriptionIsExpired']===2) && $userPaymentCheck[0]['UserPackageCode']=== $userId['UserPackageType']) {

                }
                }
                else{
                    if($subscription['OperatorId'] == '100001'){
                        $operatorName="Mobilink";
                    }else if($subscription['OperatorId'] == '100002')
                    {
                       $operatorName="Telenor";
                    }else if( $subscription['OperatorId'] == '100003'){
                     $operatorName="Zong";
                    }else if($subscription['OperatorId'] == '100004'){
                     $operatorName="Warid";
                    }
                    else{
                      // Not Set
                
                }     
                if($subscription['OperatorId'] == '100002'){
                    $data = array(
                        'productID' => urlencode($subscription['ProductId']),
                        'userKey' => urlencode($newUser['UserId']),
                        'referenceID' => urlencode($Params['ReferenceId']),
                        'transactionType' => 1,
                        'operatorID' => urlencode($subscription['OperatorId']),
                        );
                }else{
                    $data = array(
                        'productID' => urlencode($subscription['ProductId']),
                        'mobileNo' => urlencode($userSubscription['subscriptionNumber']),
                        'transactionType' => 1,
                        'userKey' => urlencode($lastUserId),
                        'operatorID' => urlencode($subscription['OperatorId']),
                   );
                }   
                $data_string = json_encode($data); 
                $MerchantWebKey = 'b5l6alobm3n9o9j4scdsa474b8';
                $ch = curl_init('http://111.119.160.222:9991/dcb-integration/transaction/' . $MerchantWebKey . '/WEB/make-payment');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string)
                ));
                            
                $result = json_decode(curl_exec($ch), true);
                curl_close($ch);   
                if ($result) {                                        
                    if ($result['status'] === 1) {
                       
                        $paymentLog['PaymentLogMessage']  = $result['message'];  
                        $paymentLog['PaymentLogStatus']  =  1;  
                       
                        $successPayment = userSubscriptions::saveSuccessPayment($paymentLog);                                             
                       
                     
                        $usersubscription = userSubscriptions::getUserPackageSubscription($Params['UserId'],$db);                      
            
                        $userPaymentSolution = UserPaymentLogs:: saveSuccessPayment($result);                            
                     
                        $usersubscription=userSubscriptions::getUserPackageSubscription($Params['UserId'],$db);
                      
                    }  else if($result['message']==='Insufficient Balance' && $result['status']===2)
                    {
                        $productID  =  $subscription['ProductId']; 
                        $operatorID =  $subscription['OperatorId']; 
                        $lastInserteduserId     =  $lastInserteduserId;
                        $userAndroidBucket =   userSubscriptions::getAndroidBucket($productID,$operatorID);
                        if($userAndroidBucket ===1){
                        $lastInserteduserId     =  $lastInserteduserId; 
                        $failPayment = array(
                        'UserPaymentVersion'            => 'V1',
                        'UserPaymentPlatform'           => 'dcb',
                        'UserPaymentUserName'           => $lastInserteduserId,
                        'UserPaymentPackageType'        => $productID,
                        'UserPaymentTransactionId'      => $result['transactionID'],
                        'UserPaymentIP'                 => $user['UserIPAddress'],
                        'UserPaymentMobileNumber'       => $userSubscription['subscriptionNumber'],
                        'UserPaymentOperatorID'         => $operatorID,
                        'UserPaymentMessage'            => $result['message']
                        );
                       
                        $failPaymentsArray = userSubscriptions::saveFailPaymentTranscation($failPayment);
                        $usersubscription  = userSubscriptions::getUserPackageSubscription($userId);
                       }
                       else {
                        $obj['Transaction-Fail']='Transaction-Fail';
                       }

                    }   
                    else {
                     //   $log->info('E_NO_PAYMENT : ' . $result['message']);

                      //  $LogInsertArray['PaymentLogMessage'] = $result['message'];
                     //   $db->insert("userpaymentlogs", $LogInsertArray);
                     //   $obj['System-Fail']='System-Fail';
                     //   PaymentSolutions::webengageAPI($Params['UserId'],$Params['ProductId'],$Params['MobileNo'],$Params['OperatorId'],"Subscription",$obj,$db);
                       
                       
                    //   return General::getResponse($response->write(ErrorObject::getUserErrorsObjects(Message::getErrorMessageAndCode($result['message'], $result['status']))));
                    }   
                }  else {
                    $log->info('E_NO_PAYMENT : NO RESPONSE FROM SIMPAISA');

                    $LogInsertArray['PaymentLogMessage'] = "NO RESPONSE FROM SIMPAISA";
                }                               
                           
                }

        }

           
        return redirect('userSubscription');
          
       }
       public function search(Request $request) {
        $constraints = [
            'UserUsername' => $request['mobilenumber']
            ];
       $userSubscription = userSubscriptions::getUserSubscription($constraints);
       return view('userSubscription/index', ['userSubscription' => $userSubscription,'searchingVals' => $constraints]);
    }
    public function export(){
        $date = date('Y-m-d');
        $subscription = usersubscriptions::getAllUserSubscription($date);
        $subscription = json_encode($subscription);
        $subscription = json_decode($subscription,true);
        Excel::create('subscriptions', function($excel) use($subscription) {
            $excel->sheet('ExportFile', function($sheet) use($subscription) {
                $sheet->fromArray($subscription);
            });
        })->export('csv');
  
      }
    }
