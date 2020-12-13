<?php

namespace App\MessageHandler;

use App\Entity\Telemetry;
use App\Message\CheckTriggers;
use App\Message\MercurePublish;
use App\Message\SaveDeviceTelemetry;
use App\Repository\DeviceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class SaveDeviceTelemetryHandler implements MessageHandlerInterface
{

    public function __construct(DeviceRepository $deviceRepository,EntityManagerInterface $em,MessageBusInterface $bus)
    {
        $this->deviceRepository=$deviceRepository;
        $this->em=$em;
        $this->bus=$bus;
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

        //send to check for triggers
        $this->bus->dispatch(new CheckTriggers($device,json_decode($message->getMessage(),true)));
//        $this->bus->dispatch(new MercurePublish($device->getId(),json_decode($message->getMessage(),true)));
        $update = new Update(
            'devices/'.$device->getId().'/telemetry', $message->getMessage()
        );
        $this->bus->dispatch($update);
        return true;
    }
}
