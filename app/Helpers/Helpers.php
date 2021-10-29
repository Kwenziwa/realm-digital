<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class Helpers
{

    public static function GetApi($url)
    {

        $client = new Client();
        $res = $client->request('GET', $url);
        return json_decode($res->getBody()->getContents(), true);
    }


    public static function PostApi($url,$body) {
        $client = new Client();
        $response = $client->request("POST", $url, ['form_params'=>$body]);
        $response = $client->send($response);
        return $response;
    }


    public static function is_leap_year($year)
    {
        return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year %400) == 0)) && now()->day == 29 && now()->month == 2);
    }

    public static function wishTypeArray($position){

        $wish_type = collect(['dateOfBirth','employmentStartDate']);
        return $wish_type[$position];
    }

    public static function wishTitleTypeArray($position){

        $wishTitle = collect(['Happy Birthday','Happy Work Anniversary']);
        return $wishTitle[$position];
    }

    public static function wishBodyTypeArray($position){

        $wishBody = collect(['Wishing you many more years of good health and prosperity.','Congratulations on another successful year of service.']);
        return $wishBody[$position];
    }




}
