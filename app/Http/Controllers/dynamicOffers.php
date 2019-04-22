<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\dynamicOffer;
use App\promoCode;
use App\Http\Requests;
use App\userRole;
use DB;
use Auth;


class dynamicOffers extends Controller
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
    public function index()
    {
         $dynamicOffers = DB::table('dynamicoffers')
        ->select('id','title', 'description','expiryDate','packageCode')
        ->paginate(10);
        return view('dynamicOffers/index', ['dynamicOffer' => $dynamicOffers]);
    }
    public function create()
    {
        $packageCode = dynamicOffer::getPackageType();
        return view('dynamicOffers/create');
    }
    public function storeFormData(Request $request)
    {
        $dynamicOfferArray = $request->all();
        $this->validateInput($request);
     
           if($dynamicOfferArray){
               // Date range break from start and expiry and format setting
            $dateRange = explode(' - ', $_POST['datefilter']);
            $startDate  = $dateRange[0];
            $startDate = date('Y-m-d', strtotime($startDate));
            $expiryDate = $dateRange[1]; 
            $expiryDate = date('Y-m-d', strtotime($expiryDate));
              // Date range break from start and expiry and format setting
             $offerID = dynamicOffer::create([
            'title'           => $dynamicOfferArray['title'],
            'description'     => $dynamicOfferArray['description'],
            'startDate'       => $startDate,
            'expiryDate'      => $expiryDate,
            'packageCode'     => $dynamicOfferArray['packageCode'],
            'isBucket'        => $dynamicOfferArray['isBucket'],
            'image'           => $dynamicOfferArray['imageURL']
        ]);
       $id = promoCode::create([
            'offerID'         => $offerID['id'],
            'promoCode'       => $dynamicOfferArray['promoCode'],
        ]);
          
        }
        if($id){
            return redirect('dynamicOffers')->with('success','Dynamic Offer Created successfully!');
            // return back()->with('success','Dynamic Offer Created successfully!');
        }
       
        return redirect('dynamicOffers');
    }
    public function store(Request $request)
    {
           $path = $request->file('csv_file')->getRealPath();
           $dynamicOfferArray = Excel::load($path, function($reader) {})->get()->toArray();
        //    print_r($dynamicOfferArray); exit;
            if (count($dynamicOfferArray) > 0) {
            for ($i = 0; $i < count($dynamicOfferArray); $i++) {
                $startDate  = date('Y-m-d-h-i-s',strtotime($dynamicOfferArray[$i]['startdate']));
                $expiryDate = date('Y-m-d-h-i-s',strtotime($dynamicOfferArray[$i]['expirydate']));
            $offerID = dynamicOffer::create([
            'title'           => $dynamicOfferArray[$i]['title'],
            'description'     => $dynamicOfferArray[$i]['description'],
            'startDate'       => $startDate,
            'expiryDate'      => $expiryDate,
            'packageCode'     => $dynamicOfferArray[$i]['packagecode'],
            'isBucket'        => $dynamicOfferArray[$i]['isbucket'],
            'image'           => $dynamicOfferArray[$i]['imageurl']
        ]);
        }
        for ($i = 0; $i < count($dynamicOfferArray); $i++) {
        $id =    promoCode::create([
                'offerID'         => $offerID['id'],
                'promoCode'       => $dynamicOfferArray[$i]['promocode'],
            ]);
        }
       
    }
       
        return redirect('dynamicOffers');
    }
    public function edit($id)
    {
        $dynamicOffers = dynamicOffer::find($id);
        // Redirect to city list if updating city wasn't existed
        if ($dynamicOffers == null) {
            return redirect('dynamicOffers');
        }
        return view('dynamicOffers/edit', ['dynamicOffer' => $dynamicOffers]);
    }
    public function update(Request $request, $id)
    {
        $dynamicOffers = dynamicOffer::findOrFail($id);
        $this->validateInput($request);
        if($dynamicOffers){
            $dateRange = explode(' - ', $_POST['datefilter']);
            $startDate  = $dateRange[0];
            $startDate = date('Y-m-d', strtotime($startDate));
            $expiryDate = $dateRange[1]; 
            $expiryDate = date('Y-m-d', strtotime($expiryDate));
            $input = [
                'title'           => $request['title'],
                'description'     => $request['description'],
                'startDate'       => $startDate,
                'expiryDate'      => $expiryDate,
                'packageCode'     => $request['packageCode'],
                'isBucket'        => $request['isBucket'],
                'image'           => $request['imageURL']
            ];
          
        }
        dynamicOffer::where('id', $id)
            ->update($input);
        
        return redirect('dynamicOffers');
    }
    public function exportCSV()
    {
      return Excel::download(new ListExport, 'list.csv');
    }
    
    public function createoffers()
    {
        $packageCode = dynamicOffer::getPackageType();
        return view('dynamicOffers/createForm', ['packageCode' => $packageCode]);
    }

    public function show()
    {
        return view('dynamicOffers/createForm');
    }
    public function destroy($id)
    {
        dynamicOffer::where('id', $id)->delete();
        return view('dynamicOffers');
    }

    private function validateInput($request) {
        $this->validate($request, [
        'datefilter'  => 'required|max:60',
        'packageCode' => 'required|max:6',
        'imageURL'       => 'required'
    ]);
    }
}
