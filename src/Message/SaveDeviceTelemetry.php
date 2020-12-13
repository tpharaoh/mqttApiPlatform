<?php

namespace App\Message;

final class SaveDeviceTelemetry
{
    /*
     * Add whatever properties & methods you need to hold the
     * data for this message class.
     */

    private $topic;
    private $message;

    public function __construct(string $topic, string $message)
    {
        $this->message=$message;
        $this->topic = $topic;

    }

    public function getMessage(): string
    {
        return $this->message;
    }
    public function getTopic(): string
    {
        return $this->topic;
    }
}
