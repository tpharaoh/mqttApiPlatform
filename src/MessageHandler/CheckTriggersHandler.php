<?php

namespace App\MessageHandler;

use App\Message\CheckTriggers;
use App\Repository\TriggerRepository;
use App\Utility\Nexmo;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CheckTriggersHandler implements MessageHandlerInterface
{
    public function __construct(TriggerRepository $triggerRepository,ParameterBagInterface $params)
    {
        $this->triggerRepository=$triggerRepository;
        $this->params=$params;
    }

    public function __invoke(CheckTriggers $message)
    {
        // do something with your message
        $telemetryKey=array_keys($message->getTelemetry());
        $trigger = $this->triggerRepository->findOneBy([
            'device'=>$message->getDevice(),
            'telemetryKey'=>$telemetryKey[0]
        ]);
            if($trigger){
                if($message->getTelemetry()[$telemetryKey[0]]<$trigger->getLowValue()){
                    $sms=new Nexmo();
                    $sms->setCredentials($this->params->get('SMS_KEY'),$this->params->get('SMS_TOKEN'));
//                    echo $sms->sendSMS($this->params->get('SMS_SENDER'),'306945555258','value too low');
                }
                if($message->getTelemetry()[$telemetryKey[0]]>$trigger->getHighValue()){
                    $sms=new Nexmo();
                    $sms->setCredentials($this->params->get('SMS_KEY'),$this->params->get('SMS_TOKEN'));
//                    echo $sms->sendSMS($this->params->get('SMS_SENDER'),'306945555258','value too high');
                }

            }
    }
}
