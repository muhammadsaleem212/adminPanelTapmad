<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\userRole;
use Auth;


class UserManagementController extends Controller
{
    
    protected $redirectTo = '/user-management';

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
        $users = User::paginate(5);

        return view('UserManagementController/index', ['users' => $users]);
    }

    public function create()
    {
        $roles   = userRole::all();
        return view('UserManagementController/create', ['role' => $roles]);
    }


    public function store(Request $request)
    {
        $this->validateInput($request);
         User::create([
            'username'     => $request['username'],
            'user_role_id' => $request['userRoleID'],
            'email'        => $request['email'],
            'password'     => bcrypt($request['password']),
            'firstname'    => $request['firstname'],
            'lastname'     => $request['lastname']
        ]);

        return redirect()->intended('UserManagementController');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user  = User::find($id);
        $roles   = userRole::all();
        // Redirect to user list if updating user wasn't existed
        if ($user == null) {
            return redirect()->intended('UserManagementController');
        }

        return view('UserManagementController/edit', ['user' => $user,'roles' => $roles]);
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
        $user = User::findOrFail($id);
        $constraints = [
            'username' => 'required|max:20',
            'firstname'=> 'required|max:60',
            'lastname' => 'required|max:60'
            ];
        $input = [
            'username'     => $request['username'],
            'user_role_id' => $request['userRoleID'],
            'firstname'    => $request['firstname'],
            'lastname'     => $request['lastname']
        ];
        if ($request['password'] != null && strlen($request['password']) > 0) {
            $constraints['password'] = 'required|min:6|confirmed';
            $input['password'] =  bcrypt($request['password']);
        }
        $this->validate($request, $constraints);
        User::where('id', $id)
            ->update($input);
        
        return redirect()->intended('UserManagementController');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
         return redirect()->intended('UserManagementController');
    }

    /**
     * Search user from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'username' => $request['username'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'department' => $request['department']
            ];

       $users = $this->doSearchingQuery($constraints);
       return view('UserManagementController/index', ['users' => $users, 'searchingVals' => $constraints]);
    }

    private function doSearchingQuery($constraints) {
        $query = User::query();
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
        'username'      => 'required|max:20',
        'userRoleID'    => 'required|max:20',
        'email'         => 'required|email_domain:' . $request['email'] . '|max:255|unique:users',
        'password'      => 'required|min:6|confirmed',
        'firstname'     => 'required|max:60',
        'lastname'      => 'required|max:60'
    ]);
    }
}
