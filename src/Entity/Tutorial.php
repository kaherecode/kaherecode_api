<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\TutorialRepository")
 */
class Tutorial
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups("read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"read", "write"})
     *
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Groups("read")
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"read", "write"})
     */
    private $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"read", "write"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"read", "write"})
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"read", "write"})
     */
    private $video;

    /**
     * @ORM\Column(type="integer")
     *
     * @Groups("read")
     */
    private $views;

    /**
     * @ORM\Column(type="integer")
     *
     * @Groups("read")
     */
    private $readings;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"read", "write"})
     */
    private $demo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"read", "write"})
     */
    private $sourceCode;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups("read")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups("read")
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups("read")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups("read")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->isPublished = false;
        $this->views = 0;
        $this->readings = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getReadings(): ?int
    {
        return $this->readings;
    }

    public function setReadings(int $readings): self
    {
        $this->readings = $readings;

        return $this;
    }

    public function getDemo(): ?string
    {
        return $this->demo;
    }

    public function setDemo(?string $demo): self
    {
        $this->demo = $demo;

        return $this;
    }

    public function getSourceCode(): ?string
    {
        return $this->sourceCode;
    }

    public function setSourceCode(?string $sourceCode): self
    {
        $this->sourceCode = $sourceCode;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
