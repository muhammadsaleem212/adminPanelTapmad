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
use App\userScreen;
use DB;
use Auth;

class userScreens extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $userScreens = userScreen::paginate(5);
        return view('usersscreens/index', ['userScreen' => $userScreens]);
    }

    public function create()
    {
        return view('users-screens/create');
    }

    public function store(Request $request)
    {
       
        $userScreens = $request->all();
        $checkUserScreen = userScreen::checkUserScreen($userScreens);
        if($checkUserScreen){ 
            echo "user Screen Already Exist";
       }else{
        $userScreen = array();
        $userScreen['userScreenName'] = $userScreens['userScreens'];
        $create = userScreen::create($userScreen);
    
        return redirect('users-screens');
          
       }
    }

    public function edit($id)
    {
        $userScreens = userScreen::query()->find($id); 
        if ($userScreens == null) {
            return redirect('users-screens');
        }
        return view('users-screens/edit', ['userScreen' => $userScreens]);
    }
    public function search(Request $request) {
        $constraints = [
            'userRolesName' => $request['userRole']
            ];

       $userRoles = $this->doSearchingQuery($constraints);
       return view('users-roles/index', ['userRole' => $userRoles,'searchingVals' => $constraints]);
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
      $userScreenName = array(
       'userScreenName' => $request['userScreen']
      ); 
    userScreen::where('id', $id)->update($userScreenName);
    return redirect('users-screens');
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
        return redirect('users-roles');
    }

}
