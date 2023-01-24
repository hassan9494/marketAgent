<?php

namespace App\Services;

class SymService
{
    private $key ='';
    private $base_url='https://provider.market-syria.com/api/v1';

    public function serverRequest($params = [])
    {
        $this->key = env("PROVIDER_API_KEY", "test");

        $ch = curl_init();
        $par = '';
        foreach ($params as $key=>$param){
            $par = $par.'&'.$key.'='.$param;

        }

        $url = $this->base_url .'?key='. $this->key.$par;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpcode!=200) {
            dd($result);
            dd($httpcode);
            return 0;
        }

        curl_close($ch);
        $result = json_decode($result, True);
//        dd()
        return $result;
    }

}
