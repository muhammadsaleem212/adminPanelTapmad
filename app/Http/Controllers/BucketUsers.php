<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\userPromoCodes;
use App\userRole;
use App\BucketUsersModel;
use App\Http\Requests;
use DB;
use Auth;

class BucketUsers extends Controller
{
    //
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

    public function index(Request $request)
    {  
    $BucketUserMessage = BucketUsersModel::getBucketUsersMessage();      
  
    $inputRequest = $request->all();
    $Export = $request->input('Export');
    $BucketMessage =  $request->input('PaymentMessage');
    if($inputRequest){
        if($BucketMessage){
            $dateRange['UserPaymentMessage'] = $BucketMessage;
        }
        $dateRangeFrom = explode(' - ', $_POST['daterange']);
       if($dateRangeFrom[0]){
        $startDate  = $dateRangeFrom[0];
        $dateRange['UserSubscriptionStartDate'] = date('Y-m-d H:i:s', strtotime($startDate));
        $expiryDate = $dateRangeFrom[1]; 
        $dateRange['UserSubscriptionExpiryDate'] = date('Y-m-d H:i:s', strtotime($expiryDate));
       }else{
        $dateRange['UserSubscriptionStartDate'] = date("Y-m-d H:i:s");
        $dateRange['UserSubscriptionExpiryDate'] = date("Y-m-d H:i:s");
       }
        $BucketUsers = BucketUsersModel::getBucketUsers($dateRange);   
        if($Export){
              $arrResult = json_encode($BucketUsers);
              $arrResult = json_decode($BucketUsers,true);
         Excel::create('BucketUsers', function($excel) use($arrResult) {
            $excel->sheet('ExportFile', function($sheet) use($arrResult) {
                $sheet->fromArray($arrResult);
            });
        })->export('csv');
       }
         }else{
         $dateRange['UserSubscriptionStartDate'] = date('Y-m-d');
         $dateRange['UserSubscriptionExpiryDate'] = date('Y-m-d');
         $BucketUsers = BucketUsersModel::getBucketDefault($dateRange);  
         }
         return view('BucketUsers/index', ['BucketUsers' => $BucketUsers, 'BucketUserMessage' => $BucketUserMessage]);         
    }
}
