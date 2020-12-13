<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Device\DeviceCollectionCreateController;
use App\Repository\DeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"device_read"}},
 *     collectionOperations={
 *          "post"={
 *              "controller"=DeviceCollectionCreateController::class,
 *              "security"="is_granted('ROLE_USER')",
 *              "normalization_context"={"groups"={"device_read"}},
 *          },
 *          "get"={
 *              "normalization_context"={"groups"={"device_read"}},
 *          }
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"device_read"}},
 *          },
 *          "put"={
 *              "normalization_context"={"groups"={"device_read"}},
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass=DeviceRepository::class)
 */
class Device
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     * @Groups({"device_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"device_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"device_read"})
     */
    private $deviceType;

    /**
     * @ORM\ManyToOne(targetEntity=Owner::class, inversedBy="devices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=Telemetry::class, mappedBy="device", orphanRemoval=true)
     * @Groups({"device_read"})
     */
    private $telemetries;

    /**
     * @ORM\OneToMany(targetEntity=Trigger::class, mappedBy="device")
     */
    private $triggers;

    public function __construct()
    {
        $this->telemetries = new ArrayCollection();
        $this->triggers = new ArrayCollection();
    }

    public function getId()
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

    /**
     * @return Collection|Trigger[]
     */
    public function getTriggers(): Collection
    {
        return $this->triggers;
    }

    public function addTrigger(Trigger $trigger): self
    {
        if (!$this->triggers->contains($trigger)) {
            $this->triggers[] = $trigger;
            $trigger->setDevice($this);
        }

        return $this;
    }

    public function removeTrigger(Trigger $trigger): self
    {
        if ($this->triggers->removeElement($trigger)) {
            // set the owning side to null (unless already changed)
            if ($trigger->getDevice() === $this) {
                $trigger->setDevice(null);
            }
        }

        return $this;
    }
}
