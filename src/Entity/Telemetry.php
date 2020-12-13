<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TelemetryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TelemetryRepository::class)
 */
class Telemetry
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private $id;



    /**
     * @ORM\Column(type="json")
     */
    private $receivedData=[];

    /**
     * @ORM\ManyToOne(targetEntity=Owner::class)
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity=Device::class, inversedBy="telemetries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $device;

    public function getId()
    {
        return $this->id;
    }



    public function getReceivedData(): ?array
    {
        return $this->receivedData;
    }

    public function setReceivedData(array $receivedData): self
    {
        $this->receivedData = $receivedData;

        return $this;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getDevice(): ?Device
    {
        return $this->device;
    }

    public function setDevice(?Device $device): self
    {
        $this->device = $device;

        return $this;
    }
}
