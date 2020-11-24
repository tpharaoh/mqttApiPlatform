<?php


namespace App\Interfaces;


interface SMSProviderInterface
{
    public function setCredentials($key='',$token='');

    public function sendSMS($from_number,$to_number,$text);

}