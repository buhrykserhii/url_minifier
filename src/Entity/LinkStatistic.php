<?php

namespace App\Entity;

use App\Repository\LinkStatisticRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LinkStatisticRepository::class)
 */
class LinkStatistic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity=Link::class, inversedBy="statistics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $link;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(?int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getLink(): ?Link
    {
        return $this->link;
    }

    public function setLink(?Link $link): self
    {
        $this->link = $link;

        return $this;
    }

}
