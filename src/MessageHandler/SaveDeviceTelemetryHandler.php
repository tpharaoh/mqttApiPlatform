<?php

namespace App\MessageHandler;

use App\Entity\Telemetry;
use App\Message\SaveDeviceTelemetry;
use App\Repository\DeviceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SaveDeviceTelemetryHandler implements MessageHandlerInterface
{

    public function __construct(DeviceRepository $deviceRepository,EntityManagerInterface $em)
    {
        $this->deviceRepository=$deviceRepository;
        $this->em=$em;
    }

    public function __invoke(SaveDeviceTelemetry $message)
    {

        $deviceData=explode('/',$message->getTopic());
        $device=$this->deviceRepository->find(end($deviceData));

        $telemetry = new Telemetry();
        $telemetry->setDevice($device);
        $telemetry->setOwner($device->getOwner());
        $telemetry->setReceivedData(json_decode($message->getMessage(),true));
        $this->em->persist($telemetry);
        $this->em->flush();

        return true;
    }
}
