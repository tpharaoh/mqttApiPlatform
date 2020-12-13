<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=DeviceRepository::class)
 */
class Device
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $deviceType;

    /**
     * @ORM\ManyToOne(targetEntity=Owner::class, inversedBy="devices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=Telemetry::class, mappedBy="device", orphanRemoval=true)
     */
    private $telemetries;

    public function __construct()
    {
        $this->telemetries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDeviceType(): ?string
    {
        return $this->deviceType;
    }

    public function setDeviceType(string $deviceType): self
    {
        $this->deviceType = $deviceType;

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

    /**
     * @return Collection|Telemetry[]
     */
    public function getTelemetries(): Collection
    {
        return $this->telemetries;
    }

    public function addTelemetry(Telemetry $telemetry): self
    {
        if (!$this->telemetries->contains($telemetry)) {
            $this->telemetries[] = $telemetry;
            $telemetry->setDevice($this);
        }

        return $this;
    }

    public function removeTelemetry(Telemetry $telemetry): self
    {
        if ($this->telemetries->removeElement($telemetry)) {
            // set the owning side to null (unless already changed)
            if ($telemetry->getDevice() === $this) {
                $telemetry->setDevice(null);
            }
        }

        return $this;
    }
}
