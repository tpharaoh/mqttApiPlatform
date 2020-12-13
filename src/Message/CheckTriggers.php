<?php

namespace App\Message;

use App\Entity\Device;

final class CheckTriggers
{
    /*
     * Add whatever properties & methods you need to hold the
     * data for this message class.
     */

     private $device;
     private $telemetry;

     public function __construct(Device $device,array $telemetry)
     {
         $this->device = $device;
         $this->telemetry=$telemetry;
     }

    public function getDevice(): Device
    {
        return $this->device;
    }

    public function getTelemetry(): array
    {
        return $this->telemetry;
    }
}
