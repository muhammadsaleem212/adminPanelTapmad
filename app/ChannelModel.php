<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ChannelModel extends Model
{
    protected $fillable = [
        'channelID','question','option',
    ];
    public static function getChannels(){
        $channels = DB::table('channels')
        ->leftJoin('channelcategories', 'channelcategories.ChannelCategoryId', '=', 'channels.ChannelCategory')
        ->select('ChannelName','ChannelDescription','ChannelIsOnline','ChannelCategoryName')
        ->get();
        
        return $channels;
      
     }  
     public static function getIncomingChannels(){
        $IncomingChannels = DB::table('channels')
        ->select('ChannelId','ChannelName','ChannelIsOnline')
        ->where('IsComingSoon', 1)
        ->get();
        
        return $IncomingChannels;
      
     }  
     protected $table = 'channelsquestions';
}
