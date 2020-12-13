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
    private $telemetryKey;

    /**
     * @ORM\Column(type="integer")
     */
    private $highValue;

    /**
     * @ORM\Column(type="integer")
     */
    private $lowValue;

    /**
     * @ORM\ManyToOne(targetEntity=Device::class, inversedBy="triggers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $device;

    public function getId(): ?int
    {
        return $this->id;
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
