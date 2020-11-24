<?php


namespace App\Utility;


use App\Interfaces\SMSProviderInterface;
use Symfony\Component\HttpClient\HttpClient;

class Nexmo implements SMSProviderInterface
{


    private $key;
    private $token;

    public function setCredentials($key='',$token='')
    {
        $this->key=$key;
        $this->token=$token;
    }

    public function sendSMS($from_number,$to_number, $text)
    {
        $client=HttpClient::create();
        try {
            $status=$client->request('POST','https://rest.nexmo.com/sms/json',[
                'json'=>[
                    'from'=>$from_number,
                    'text'=>$text,
                    'to'=>$to_number,
                    'api_key'=>$this->key,
                    'api_secret'=>$this->token,
                ]
            ]);
            return $status->getContent();
        }catch (\Exception $exception){
            return $exception;
        }
    }
}