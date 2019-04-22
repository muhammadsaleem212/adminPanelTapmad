<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\ChannelModel;
use App\userRole;
use App\Http\Requests;
use DB;
use Auth;

class ChannelController extends Controller
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
        $channels = channelModel::getChannels();
        return view('Channels/index', ['channels' => $channels]);
    }
    public function create()
    {
        $channelsIncoming = channelModel::getIncomingChannels();
        return view('Channels/create', ['ChannelsIncoming' => $channelsIncoming]);
    }
    public function store(Request $request)
    {
        $channelsQuestions = $request->all();
        $this->validate($request, [
            'channelID'         => 'required|unique:channelsquestions',
            'channelQuestion'   => 'required',
            'name'              => 'required'
        ]);
        $channelOptions = $channelsQuestions['name'];
        for($i = 0; $i < count($channelOptions); $i++){
           $option[] = $channelOptions[$i];
        }
        $optionImplode = implode(',', $option);
       
     
           if($channelsQuestions){
             
            ChannelModel::create([
            'channelID'         => $channelsQuestions['channelID'],
            'question'          => $channelsQuestions['channelQuestion'],
            'option'            => $optionImplode,
        ]);
        }
       
        return redirect('ChannelController');
    }
       
}
