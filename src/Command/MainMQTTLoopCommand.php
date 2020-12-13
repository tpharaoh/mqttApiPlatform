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

        }, 0);

        //QOS 0 prevents a cluster from reading on each instance in a queue

        $client->loop(true);

    }
}