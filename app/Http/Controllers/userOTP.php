<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\userOTPmodel;
use App\userRole;
use DB;
use Auth;


class userOTP extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->only(["index", "create", "store", "edit", "update", "search", "destroy"]); 
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
         $userMobileNo = $request->all();
         $userOTP = "";
         if($userMobileNo == "" || $userMobileNo == null){
            return view('userOTP/index', ['userOTP' => $userOTP]);
         }
      
        $userMobileNo = filter_var($userMobileNo['mobilenumber'], FILTER_SANITIZE_STRING);
        $userMobileNo = ltrim($userMobileNo, '0');
        $userMobileNo = ltrim($userMobileNo, '+92');
        $userOTP = userOTPmodel::getUserOTP($userMobileNo);
        return view('userOTP/index', ['userOTP' => $userOTP]);
    }

}
