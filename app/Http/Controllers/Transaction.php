<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;

use Illuminate\Http\Request;

class Transaction extends Controller
{
    //
    public function __construct(){
     
    }
    public function index(){
       
    //     // $date = date('d-m-Y');

    //     // $date = str_replace('-', '.', $date);
    //     // print_r(intval($date)); exit;
          ini_set('max_execution_time', 600);
      //    $json = $client->get('http://app.tapmad.com/api/getTapmadLossTranscation/1.4.2019');
          $json = json_decode(file_get_contents('http://app.tapmad.com/api/getTapmadLossTranscation/1.4.2019'), true);
          print_r($json); exit;
          //   //   print_r($json); exit;
    //   $client = new Client();

    // $res = $client->request('GET', 'http://app.tapmad.com/api/getTapmadLossTranscation/1.4.2019', [
    // ]);

    // if ($res->getStatusCode() == 200) { // 200 OK
    //     $response_data = $res->getBody()->getContents();
    // }
    // echo "<pre>";
    // print_r($response_data); exit;
    //     $client = new Client();
    //     $api_response = $client->get('http://app.tapmad.com/api/getTapmadLossTranscation/1.4.2019');
    //  echo "<pre>";
    //     print_r($api_response); exit;
    //     $response = json_encode($api_response);
    //     print_r($response); exit;
    ini_set('max_execution_time', 6000);
    
    $content = file_get_contents("http://app.tapmad.com/api/getTapmadLossTranscation/1.4.2019");
 //   $content = file_get_contents("http://apinew.tapmad.com/api/getFeaturedHomePageDetail/v1/en/web/5");
    echo "<pre>";
    print_r($content); exit;
    $curl = curl_init();

 curl_setopt_array($curl, array(
  CURLOPT_URL => "http://app.tapmad.com/api/getTapmadLossTranscation/1.4.2019",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 3000,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
print_r($response); exit;
$err = curl_error($curl);

curl_close($curl);
    $json = json_decode(file_get_contents('http://host.com/api/v1/users/1'), true);
    print_r($json); exit;
     $url = 'http://app.tapmad.com/api/getTapmadLossTranscation/1.4.2019';
    $client = new Client();
    $result = $client->get($url, [
        'headers' => [
            'Content-Type' => 'application/json',
            'X-AUTH-TOKEN' => env('CURRENT-AUTH-TOKEN'),
            'X-SUBDOMAIN' => env('CURRENT-SUBDOMAIN')
        ]
    ]);
    $array = json_decode($result->getBody()->getContents(), true);
    print_r($array); exit;

    return $array;
    }
}
