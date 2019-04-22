<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\userPromoCodes;
use App\userRole;
use App\TransactionFailedModel;
use App\Http\Requests;
use DB;
use Auth;


class TransactionFailed extends Controller
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
    $TransactionFailedMessage = TransactionFailedModel::getFailedTransactionMesage();  
    $inputRequest = $request->all();
    $Export = $request->input('Export');
    $PaymentMessage =  $request->input('PaymentMessage');
  //  print_r($PaymentMessage); exit;
    if($inputRequest){
        if($PaymentMessage){
            $dateRange['UserPaymentMessage'] = $PaymentMessage;
        }
        $dateRangeFrom = explode(' - ', $_POST['daterange']);
        $startDate  = $dateRangeFrom[0];
        $dateRange['UserPaymentStartDate'] = date('Y-m-d H:i:s', strtotime($startDate));
        $expiryDate = $dateRangeFrom[1]; 
        $dateRange['UserPaymentEndDate'] = date('Y-m-d H:i:s', strtotime($expiryDate));
        $FailedTransaction = TransactionFailedModel::getFailedTransaction($dateRange);   
        if($Export){
              $arrResult = json_encode($FailedTransaction);
              $arrResult = json_decode($FailedTransaction,true);
         Excel::create('FailedTransaction', function($excel) use($arrResult) {
            $excel->sheet('ExportFile', function($sheet) use($arrResult) {
                $sheet->fromArray($arrResult);
            });
        })->export('csv');
       }
         }else{
         $FailedTransaction = TransactionFailedModel::all();   
         }
         return view('TransactionFailed/index', ['TransactionFailed' => $FailedTransaction, 'FailedTransactionMessage' => $TransactionFailedMessage]);         
    }
    // public function export(Request $request){

    //     $FailedTransaction = $request->all();
    //     print_r($FailedTransaction); exit;
    //    if($FailedTransaction){
    //     $dateRange['startDate'] = date('Y-m-d');
    //     $dateRange['expiryDate'] = date('Y-m-d');
    //    }else{
    //     $dateRange = explode(' - ', $_POST['daterange']);
    //     $startDate  = $dateRange[0];
    //     $dateRange['startDate'] = date('Y-m-d', strtotime($startDate));
    //     $expiryDate = $dateRange[1]; 
    //     $dateRange['expiryDate'] = date('Y-m-d', strtotime($expiryDate));
    //     $FailedTransaction = TransactionFailedModel::getFailedTransaction();
    //     // $FailedTransaction = json_encode($FailedTransaction);
    //     // $FailedTransaction = json_decode($FailedTransaction,true);
    //    }
    //    $FailedTransaction = TransactionFailedModel::getFailedTransaction();
    //     Excel::create('FailedTransaction', function($excel) use($FailedTransaction) {
    //         $excel->sheet('ExportFile', function($sheet) use($FailedTransaction) {
    //             $sheet->fromArray($FailedTransaction);
    //         });
    //     })->export('csv');
    //     return redirect('FailedTransaction');  
    //   }
     
}
