<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BinnacleAccessUser
 *
 * @ORM\Table(name="binnacle_access_user", indexes={@ORM\Index(name="fk_binnacle_access_user_user1_idx", columns={"user_id"})})
 * @ORM\Entity
 */
class BinnacleAccessUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string|null
     *
     * @ORM\Column(name="system", type="string", length=3000, nullable=true)
     */
    private $system;

    /**
     * @var string|null
     *
     * @ORM\Column(name="device", type="string", length=45, nullable=true)
     */
    private $device;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adreess", type="string", length=45, nullable=true)
     */
    private $adreess;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSystem(): ?string
    {
        return $this->system;
    }

    public function setSystem(?string $system): self
    {
        $this->system = $system;

        return $this;
    }

    public function getDevice(): ?string
    {
        return $this->device;
    }

    public function setDevice(?string $device): self
    {
        $this->device = $device;

        return $this;
    }

    public function getAdreess(): ?string
    {
        return $this->adreess;
    }

    public function setAdreess(?string $adreess): self
    {
        $this->adreess = $adreess;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
