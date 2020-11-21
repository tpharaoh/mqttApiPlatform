<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TelemetryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(mercure=true)
 * @ORM\Entity(repositoryClass=TelemetryRepository::class)
 */
class Telemetry
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $device;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $receivedData;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDevice(): ?string
    {
        return $this->device;
    }

    public function setDevice(string $device): self
    {
        $this->device = $device;

        return $this;
    }

    public function getReceivedData(): ?string
    {
        return $this->receivedData;
    }

    public function setReceivedData(string $receivedData): self
    {
        $this->receivedData = $receivedData;

        return $this;
    }
}
