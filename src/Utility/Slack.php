<?php


namespace App\Utility;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Slack
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    public function initiateClient(HttpClientInterface $client)
    {
        $this->client=$client;
    }
    public function sendNotification($url,$title,$message,$action)
    {
        $client=HttpClient::create();

        $response=$client->request('POST',$url,[
            'body'=>$message,
            'headers'=>[
                'Content-Type'=>'application/json',

            ]
        ]);
    }
}