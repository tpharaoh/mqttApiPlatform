<?php


namespace App\Command;


use App\DependencyInjection\Configuration;
use App\Entity\Telemetry;
use App\Mosquitto\MosquittoClient;
use App\Repository\TriggerRepository;
use App\Utility\Nexmo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
//use App\Mosquitto\Client;
//use \Mosquitto\Message;
use PhpMqtt\Client\MQTTClient;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;

/**
 * Class MainMQTTLoopCommand
 *
 * @package App\Command
 */
class MainMQTTLoopCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'devgiants:domofony:loop';
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var PublisherInterface
     */
    private $pub;

    public function __construct(EntityManagerInterface $em,PublisherInterface $publisher,TriggerRepository $triggerRepository)
    {
        $this->em=$em;
        $this->triggerRepository=$triggerRepository;
        $this->pub=$publisher;
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
            $telemetryValue=json_decode($message)->temperature;
            $device=explode('/',$topic);
            $device=end($device);

            //check trigger
            $trigger = $this->triggerRepository->findOneByDevice($device);
            if($telemetryValue<$trigger->getLowValue()){
                $sms=new Nexmo();
                $sms->setCredentials('215be650','5IMZUeA7mjlJLoMK');
                echo $sms->sendSMS('h2o','306945825258','value too low');
            }
            //send alert

            $telemetry = new Telemetry();
            $telemetry->setDevice($device);
            $telemetry->setReceivedData($message);
            $this->em->persist($telemetry);
            $this->em->flush();


//            $publish= new Publisher();
//            $update = new Update(
//                $topic,$message
//            );
//            $publish($update);



        }, 0);


        $client->loop(true);

    }
}