<?php

namespace App\Entity;

use App\Repository\LinkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Uuid;

/**
 * @ORM\Entity(repositoryClass=LinkRepository::class)
 */
class Link
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
    private $url;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $slug;

    /**
     * @ORM\Column(type="integer")
     */
    private $finish_time;

    /**
     * @ORM\OneToMany(targetEntity=LinkStatistic::class, mappedBy="link", orphanRemoval=true)
     */
    private $statistics;

    public function __construct()
    {
        $this->statistics = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(int $id): self
    {
        $integer = $id;
        $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = strlen($base);

        while($integer > $length - 1)
        {
            $out = $base[(int)fmod($integer, $length)];
            $integer = (int)floor( $integer / $length );
        }


        if ($id > $length - 1) {
            $slug = $base[$integer] . $out;
        }
        else {
            $slug = $base[$integer];
        }

        $this->slug = $slug;

        return $this;
    }

    public function getFinishTime(): ?int
    {
        return $this->finish_time;
    }

    public function setFinishTime(int $finish_time): self
    {
        $this->finish_time = $finish_time;

        return $this;
    }

    /**
     * @return Collection<int, LinkStatistic>
     */
    public function getStatistics(): Collection
    {
        return $this->statistics;
    }

    public function addStatistic(LinkStatistic $statistic): self
    {
        if (!$this->statistics->contains($statistic)) {
            $this->statistics[] = $statistic;
            $statistic->setStatistic($this);
        }

        return $this;
    }

    public function removeStatistic(LinkStatistic $statistic): self
    {
        if ($this->statistics->removeElement($statistic)) {
            // set the owning side to null (unless already changed)
            if ($statistic->getStatistic() === $this) {
                $statistic->setStatistic(null);
            }
        }

        return $this;
    }

}
