<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"topic:read"}},
 *     denormalizationContext={"groups"={"topic:write"}}
 * )
 *
 * @UniqueEntity(fields={"label"})
 *
 * @ORM\Entity(repositoryClass="App\Repository\TopicRepository")
 */
class Topic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups("topic:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"topic:read", "topic:write", "tutorial:read"})
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tutorial", mappedBy="topic")
     *
     * @ApiSubresource
     *
     * @Groups("topic:read")
     */
    private $tutorials;

    public function __construct()
    {
        $this->tutorials = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->label;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = strtolower($label);

        return $this;
    }

    /**
     * @return Collection|Tutorial[]
     */
    public function getTutorials(): Collection
    {
        return $this->tutorials;
    }

    public function addTutorial(Tutorial $tutorial): self
    {
        if (!$this->tutorials->contains($tutorial)) {
            $this->tutorials[] = $tutorial;
            $tutorial->setTopic($this);
        }

        return $this;
    }

    public function removeTutorial(Tutorial $tutorial): self
    {
        if ($this->tutorials->contains($tutorial)) {
            $this->tutorials->removeElement($tutorial);
            // set the owning side to null (unless already changed)
            if ($tutorial->getTopic() === $this) {
                $tutorial->setTopic(null);
            }
        }

        return $this;
    }
}
