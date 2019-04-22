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
use App\userRole;
use DB;
use Auth;

class userRoles extends Controller
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
      
        $userRole = userRole::paginate(5);
        return view('userRoles/index', ['userRole' => $userRole]);
    }

    public function create()
    {
        return view('userRoles/create');
    }

    public function store(Request $request)
    {
        $userRoles = $request->all();
        $this->validate($request, [
            'userRolesName'         => 'required|unique:userRoles'
        ]);
     
        $checkUserRole = userRole::checkUserRole($userRoles);
        if($checkUserRole){ 
            return redirect('saveUserRoles');
       }else{
        $userRoleType = array();
        $userRoleType['userRolesName'] = $userRoles['userRoles'];
        $create = userRole::create($userRoleType);
    
        return redirect('userRoles/create');
          
       }
    }

    public function edit($id)
    {
        $userRoles = userRole::query()->find($id); 
        if ($userRoles == null) {
            return redirect('userRoles');
        }
        return view('userRoles/edit', ['userRole' => $userRoles]);
    }
    public function search(Request $request) {
        $constraints = [
            'userRolesName' => $request['userRole']
            ];

       $userRoles = $this->doSearchingQuery($constraints);
       return view('userRoles/index', ['userRole' => $userRoles,'searchingVals' => $constraints]);
    }
    private function doSearchingQuery($constraints) {
        $query = userRole::query();
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
    public function update(Request $request, $id)
    {  
      $userRoleName = array(
       'userRolesName' => $request['username']
      ); 
    userRole::where('id', $id)->update($userRoleName);
    return redirect('userRoles');
    }

    private function validateInput($request) {
        $this->validate($request, [
        'userRoles' => 'required|userRoles|max:255|unique:userRoles',
    ]);
    }
    public function show($id)
    {
        //
    }
    public function destroy($id)
    {
        userRoles::where('id', $id)->delete();
        return redirect('userRoles');
    }

}
