<?php


namespace App\Utilities;


use Symfony\Component\HttpClient\HttpClient;

class Sinch
{
    public function setCredentials($key='',$token='')
    {
        $this->key=$key;
        $this->token=$token;
    }

    public function sendSMS($from_number,$to_number, $text)
    {
        $client=HttpClient::create([
            'headers'=>[
                'Authorization'=>'Bearer '.$this->token,
                'Content-Type'=>'application/json'
            ]
        ]);
        try {
            $status=$client->request('POST','https://sms.api.sinch.com/xms/v1/'.$this->key.'/batches',[
                'json'=>[
                    'from'=>$from_number,
                    'to'=>[$to_number],
                    'body'=>$text
                ]
            ]);
            return $status->getContent();
        }catch (\Exception $exception){}
    }
}