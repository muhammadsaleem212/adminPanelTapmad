<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\userPromoCodes;
use App\userRole;
use App\PaymentLogsModel;
use App\Http\Requests;
use DB;
use Auth;

class PaymentLogs extends Controller
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
    public function index(Request $request)
    {  
    $PaymentLogMessage = PaymentLogsModel::getPaymentLogMessage();  
    $inputRequest = $request->all();
    $Export = $request->input('Export');
    $PaymentMessage =  $request->input('PaymentMessage');
    if($inputRequest){
        if($PaymentMessage){
            $dateRange['UserPaymentMessage'] = $PaymentMessage;
        }
        $dateRangeFrom = explode(' - ', $_POST['daterange']);
       if($dateRangeFrom[0]){
        $startDate  = $dateRangeFrom[0];
        $dateRange['PaymentLogAddedDate'] = date('Y-m-d H:i:s', strtotime($startDate));
        $expiryDate = $dateRangeFrom[1]; 
        $dateRange['PaymentLogUpdatedDate'] = date('Y-m-d H:i:s', strtotime($expiryDate));
       }else{
        $dateRange['PaymentLogAddedDate'] = date("Y-m-d H:i:s");
        $dateRange['PaymentLogUpdatedDate'] = date("Y-m-d H:i:s");
       }
        $SuccessfulTransaction = PaymentLogsModel::getPaymentLog($dateRange);   
        if($Export){
              $arrResult = json_encode($SuccessfulTransaction);
              $arrResult = json_decode($SuccessfulTransaction,true);
         Excel::create('PaymentLogs', function($excel) use($arrResult) {
            $excel->sheet('ExportFile', function($sheet) use($arrResult) {
                $sheet->fromArray($arrResult);
            });
        })->export('csv');
       }
         }else{
         $dateRange['PaymentLogAddedDate'] = date('Y-m-d');
         $dateRange['PaymentLogUpdatedDate'] = date('Y-m-d');
         $SuccessfulTransaction = PaymentLogsModel::getPaymentDefault($dateRange);  
         }
         return view('PaymentLogs/index', ['TransactionSuccessful' => $SuccessfulTransaction, 'SuccessfulTransactionMessage' => $PaymentLogMessage]);         
    }
}
