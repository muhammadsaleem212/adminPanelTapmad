<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\CategoriesModel;
use App\userRole;
use App\Http\Requests;
use DB;
use Auth;

class CategoriesController extends Controller
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
    public function index(){
       
        $categories = CategoriesModel::all();
        return view('Categories/index', ['categories' => $categories]);
    }
}
