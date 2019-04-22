<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\userPromoCodes;
use App\dynamicOffer;
use App\userRole;
use App\Http\Requests;
use DB;
use Auth;

class promoCode extends Controller
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
        $promoCode = userpromocodes::all();   
        return view('promoCode/index',['promoCode' => $promoCode]);
    }
        
    
    public function create()
    {
        $packageCode = dynamicOffer::getPackageType();
        return view('promoCode/create', ['packageCode' => $packageCode]);
    }
    public function edit($id)
    {
        $userPromoCodeObj = userpromocodes::getPromoCodeID($id); 
        $userPromoCodeJson = json_encode($userPromoCodeObj);
        $userPromoCode = json_decode($userPromoCodeJson,true);
        if ($userPromoCode == null) {
            return redirect('Admin/Marketing/promoCode');
        }
        return view('promoCode/edit', ['promoCode' => $userPromoCode]);
    }
    public function update(Request $request, $id)
    {  
      $userPromoCode = array(
       'PromoCode'              => $request['userPromoCode'],
       'PackageCode'            => $request['packageCode'],
       'PromoStartDate'         => $request['promoStartDate'],
       'PromoExpireDate'         => $request['promoExpireDate'],
       'SubscriptionDays'       => $request['subscriptionDays']
      ); 
    userpromocodes::where('PromoCodeId', $id)->update($userPromoCode);
    return redirect('promoCode');
    }

    public function store(Request $request)
    {
        $promoCode = $request->all();
       
        $this->validate($request, [
            'PromoCode'         => 'required|unique:userpromocodes|max:8',
            'packageCode'       => 'required',
            'datefilter'        => 'required',
            'promoCount'        => 'required|numeric',
            'subscriptionDays'  => 'required|numeric'
        ]);
        $packageTypeCount = $promoCode['packageCode'];
       for($i = 0; $i < count($packageTypeCount); $i++){
           $packageCode[] = $packageTypeCount[$i];
       }
       $packageCodeArr = implode(',', $packageCode);
       
        
     
           if($promoCode){
               // Date range break from start and expiry and format setting
            $dateRange = explode(' - ', $_POST['datefilter']);
            $startDate  = $dateRange[0];
            $startDate = date('Y-m-d', strtotime($startDate));
            $expiryDate = $dateRange[1]; 
            $expiryDate = date('Y-m-d', strtotime($expiryDate));
              // Date range break from start and expiry and format setting
            $id = userpromocodes::create([
            'PromoCode'        => $promoCode['PromoCode'],
            'PackageCode'      => $packageCodeArr,
            'PromoStartDate'   => $startDate,
            'PromoExpireDate'  => $expiryDate,
            'PromoCodeCount'   => $promoCode['promoCount'],
            'SubscriptionDays' => $promoCode['subscriptionDays'],
            'isUnique'         => $promoCode['isUnique']
        ]);
        }
        if($id){
            return redirect('promoCode')->with('success','Promo Code Created successfully!');
            // return back()->with('success','Dynamic Offer Created successfully!');
        }
       
        return redirect('promoCode');
    }
    public function destroy($id)
    {
        userpromocodes::where('PromoCodeId', $id)->delete();
        return redirect('promoCode');
    }

}
