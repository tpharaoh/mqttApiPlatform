<?php


namespace App\Command;

use App\Message\SaveDeviceTelemetry;
use Psr\Log\LoggerInterface;

use App\Entity\Telemetry;
use App\Repository\TriggerRepository;
use App\Utility\Nexmo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PhpMqtt\Client\MQTTClient;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MainMQTTLoopCommand
 *
 * @package App\Command
 */
class MainMQTTLoopCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'mqttLoop';
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var PublisherInterface
     */
    private $pub;
    /**
     * @var ParameterBagInterface
     */
    private $params;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus=$bus;
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {

    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $client = new MQTTClient('127.0.0.1','1883');
        $client->connect();

        $client->subscribe('device/#', function ($topic, $message) use ($output) {
            echo sprintf("Received message on topic [%s]: %s\n", $topic, $message);
            $this->bus->dispatch(new SaveDeviceTelemetry($topic,$message));

//            $telemetryValue=json_decode($message,true);
//            $device=explode('/',$topic);
//            $device=end($device);
//var_dump($telemetryValue);



                        //check trigger
//            $trigger = $this->triggerRepository->findOneByDevice($device);
//            if($trigger){
//                if($telemetryValue<$trigger->getLowValue()){
//                    $sms=new Nexmo();
//                    $sms->setCredentials($this->params->get('SMS_KEY'),$this->params->get('SMS_TOKEN'));
//                    //echo $sms->sendSMS($this->params->get('SMS_SENDER'),'306945551234','value too low');
//                }
//                if($telemetryValue>$trigger->getHighValue()){
//                    $sms=new Nexmo();
//                    $sms->setCredentials($this->params->get('SMS_KEY'),$this->params->get('SMS_TOKEN'));
//                    //echo $sms->sendSMS($this->params->get('SMS_SENDER'),'306945551234','value too high');
//                }
//
//            }

//            $date_key=date('U');
//            $telemetry[$date_key] = new Telemetry();
//            $telemetry[$date_key]->setDevice($device);
//            $telemetry[$date_key]->setReceivedData($message);
//            $this->em->persist($telemetry[$date_key]);
//            $this->em->flush();


//            the following sends on Mercure
//            $publish= new Publisher();
//            $update = new Update(
//                $topic,$message
//            );
//            $publish($update);


        }, 0);

        //QOS 0 prevents a cluster from reading on each instance in a queue

        $client->loop(true);

    }
}