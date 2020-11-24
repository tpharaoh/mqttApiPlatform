<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TriggerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TriggerRepository::class)
 */
class Trigger
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $device;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $telemetryKey;

    /**
     * @ORM\Column(type="integer")
     */
    private $highValue;

    /**
     * @ORM\Column(type="integer")
     */
    private $lowValue;

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

    public function getTelemetryKey(): ?string
    {
        return $this->telemetryKey;
    }

    public function setTelemetryKey(string $telemetryKey): self
    {
        $this->telemetryKey = $telemetryKey;

        return $this;
    }

    public function getHighValue(): ?int
    {
        return $this->highValue;
    }

    public function setHighValue(int $highValue): self
    {
        $this->highValue = $highValue;

        return $this;
    }

    public function getLowValue(): ?int
    {
        return $this->lowValue;
    }

    public function setLowValue(int $lowValue): self
    {
        $this->lowValue = $lowValue;

        return $this;
    }
}
