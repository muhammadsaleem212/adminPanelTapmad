<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\userPromoCodes;
use App\userRole;
use App\TransactionSuccessfulModel;
use App\Http\Requests;
use DB;
use Auth;

class TransactionSuccessful extends Controller
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
    $TransactionSuccessfulMessage = TransactionSuccessfulModel::getSuccessfulTransactionMessage();  
    $inputRequest = $request->all();
    $Export = $request->input('Export');
    $PaymentMessage =  $request->input('PaymentMessage');
    if($inputRequest){
        if($PaymentMessage){
            $dateRange['UserPaymentMessage'] = $PaymentMessage;
        }
        $dateRangeFrom = explode(' - ', $_POST['daterange']);
        $startDate  = $dateRangeFrom[0];
        $dateRange['UserPaymentStartDate'] = date('Y-m-d H:i:s', strtotime($startDate));
        $expiryDate = $dateRangeFrom[1]; 
        $dateRange['UserPaymentEndDate'] = date('Y-m-d H:i:s', strtotime($expiryDate));
        $SuccessfulTransaction = TransactionSuccessfulModel::getSuccessfulTransaction($dateRange);   
        if($Export){
              $arrResult = json_encode($SuccessfulTransaction);
              $arrResult = json_decode($SuccessfulTransaction,true);
         Excel::create('SuccessfulTransaction', function($excel) use($arrResult) {
            $excel->sheet('ExportFile', function($sheet) use($arrResult) {
                $sheet->fromArray($arrResult);
            });
        })->export('csv');
       }
         }else{
         $dateRange['UserPaymentStartDate'] = date('Y-m-d');
         $dateRange['UserPaymentEndDate'] = date('Y-m-d');
         $SuccessfulTransaction = TransactionSuccessfulModel::getSuccessfulTransactionDefault($dateRange);  
         }
         $constraints = [
            'UserPaymentMessage' => $request['UserPaymentMessage']
            ];
         return view('TransactionSuccessful/index', ['TransactionSuccessful' => $SuccessfulTransaction, 'SuccessfulTransactionMessage' => $TransactionSuccessfulMessage]);         
    }
}
