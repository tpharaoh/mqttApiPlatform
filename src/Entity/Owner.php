<?php

namespace App\Entity;

use App\Repository\OwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=OwnerRepository::class)
 */
class Owner implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Device::class, mappedBy="owner", orphanRemoval=true,)
     */
    private $devices;

    /**
     * @ORM\OneToMany(targetEntity=Trigger::class, mappedBy="owner")
     */
    private $triggers;

    /**
     * @ORM\OneToMany(targetEntity=NotificationMethod::class, mappedBy="owner", orphanRemoval=true)
     */
    private $notificationMethods;

    public function __construct()
    {
        $this->devices = new ArrayCollection();
        $this->triggers = new ArrayCollection();
        $this->notificationMethods = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Device[]
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(Device $device): self
    {
        if (!$this->devices->contains($device)) {
            $this->devices[] = $device;
            $device->setOwner($this);
        }

        return $this;
    }

    public function removeDevice(Device $device): self
    {
        if ($this->devices->removeElement($device)) {
            // set the owning side to null (unless already changed)
            if ($device->getOwner() === $this) {
                $device->setOwner(null);
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
            $trigger->setOwner($this);
        }

        return $this;
    }

    public function removeTrigger(Trigger $trigger): self
    {
        if ($this->triggers->removeElement($trigger)) {
            // set the owning side to null (unless already changed)
            if ($trigger->getOwner() === $this) {
                $trigger->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|NotificationMethod[]
     */
    public function getNotificationMethods(): Collection
    {
        return $this->notificationMethods;
    }

    public function addNotificationMethod(NotificationMethod $notificationMethod): self
    {
        if (!$this->notificationMethods->contains($notificationMethod)) {
            $this->notificationMethods[] = $notificationMethod;
            $notificationMethod->setOwner($this);
        }

        return $this;
    }

    public function removeNotificationMethod(NotificationMethod $notificationMethod): self
    {
        if ($this->notificationMethods->removeElement($notificationMethod)) {
            // set the owning side to null (unless already changed)
            if ($notificationMethod->getOwner() === $this) {
                $notificationMethod->setOwner(null);
            }
        }

        return $this;
    }
}
