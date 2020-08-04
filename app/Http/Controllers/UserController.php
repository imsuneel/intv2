<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers(Request $request){
        $access_token = session('accessToken');
        $apiReqURL = 'https://graph.microsoft.com/v1.0/users';
        $header = ["Content-Type: application/json",
                         "Authorization: Bearer $access_token"];
         $trackresponse = $this->intAPICommon($apiReqURL, $header, '', 'GET');
         $result = json_decode($trackresponse, true);
         return $result;
 
     }
 
     private function intAPICommon($url, $header, $data_string, $method){
         $ch = curl_init(); 
         curl_setopt($ch, CURLOPT_URL, trim($url)); 
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  
         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);  
         curl_setopt($ch, CURLOPT_POST, true);  
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
         curl_setopt($ch, CURLOPT_HTTPHEADER, $header);             
 
         $result = curl_exec($ch);
                                                                                                               
         $errors = curl_error($ch);                                                                                                            
         
         return $result;
     }

    private function get_access_token1(){
        $endpoint = 'https://login.microsoftonline.com/'.env('OAUTH_TENANT').'/oauth2/v2.0/authorize?
        client_id='.env('OAUTH_APP_ID').'
        &response_type=code
        &redirect_uri='.env('OAUTH_REDIRECT_URI').'
        &response_mode=query
        &scope=offline_access%20user.read%20mail.read
        &state=12345';
        return $endpoint;
    }
}
