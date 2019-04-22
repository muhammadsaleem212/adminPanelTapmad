<?php
  // print last query for debugging
        // $query = \DB::getQueryLog();
        // print_r(end($query)); exit;
        // $query = DB::getQueryLog();
        // print_r($query); exit;
        //  DB::enableQueryLog();
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\userPermission;
use App\userRole;
use App\userScreen;
use DB;
use Auth;

class userPermissions extends Controller
{
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $userPermissions = DB::table('userpermission')
         ->leftJoin('userroles', 'userroles.id', '=', 'userpermission.user_role_id')
         ->leftJoin('userscreens', 'userscreens.id', '=', 'userpermission.screen_id')
        ->select('userpermission.id', 'userRolesName','userScreenName')
        ->paginate(5);
        return view('userPermissions/index', ['userPermission' => $userPermissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles   = userRole::all();
        $screens = userScreen::all();
        return view('userPermissions/create', ['role' => $roles, 'screen' => $screens]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userPermissionArray = $request->all();
        $userPermissionArray['userRoleID']   = $userPermissionArray['userRoleID'];
        $userScreenID = $userPermissionArray['userScreenID'];
        $checkDuplicatePermission = array();
        for($i = 0; $i < count($userScreenID); $i++){
            $userPermission['userScreenID'][$i] = $userPermissionArray['userScreenID'][$i];
            $checkDuplicatePermission['userRoleID']   =  $userPermissionArray['userRoleID'];
            $checkDuplicatePermission['userScreenID'] =  $userPermission['userScreenID'][$i];
            $checkUserPermission = userPermission :: checkUserPermission($checkDuplicatePermission);
           if(!$checkUserPermission){
           userPermission::create([
            'user_role_id'  => $userPermissionArray['userRoleID'],
            'screen_id'     => $userPermissionArray['userScreenID'][$i]
        ]);
        }
        }
     

        return redirect('userPermissions');
    }

    public function edit($id)
    {
        $userPermission = userPermission::find($id);
        if ($userPermission == null) {
            return redirect('userPermissions');
        }
        $roles = userRole::all();
        $userScreens = userScreen::all();
        return view('userPermissions/edit', ['userPermission' => $userPermission,'roles' => $roles,'userScreen'=>$userScreens]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userPermission = userPermission::findOrFail($id);
         $this->validate($request, [
        'userScreenID' => 'required',
        'userRoleID' => 'required'
        ]);
        $input = [
            'screen_id'    => $request['userScreenID'],
            'user_role_id' => $request['userRoleID']
        ];
        userPermission::where('id', $id)
            ->update($input);
        
        return redirect('userPermissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        userPermission::where('id', $id)->delete();
        return redirect('userPermissions');
    }

    public function loadCities($stateId) {
        $cities = City::where('state_id', '=', $stateId)->get(['id', 'name']);

        return response()->json($cities);
    }

    /**
     * Search city from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request['name']
            ];

       $cities = $this->doSearchingQuery($constraints);
       return view('system-mgmt/city/index', ['cities' => $cities, 'searchingVals' => $constraints]);
    }
    
    private function doSearchingQuery($constraints) {
        $query = City::query();
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }
    private function validateInput($request) {
        $this->validate($request, [
        'screenID' => 'required',
        'userRoleID' => 'required'
    ]);
    }
    public function show($id)
    {
        //
    }

}
