<?php

namespace App\Entity;

use App\Repository\QuackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuackRepository::class)]
class Quack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'integer', nullable: false)]
    private ?int $duckID = null;
    #[ORM\Column(type: 'string', nullable: false)]
    private ?string $duckProfilePicture = null;

    public function getDuckProfilePicture(): ?string
    {
        return $this->duckProfilePicture;
    }

    public function setDuckProfilePicture(?string $duckProfilePicture): void
    {
        $this->duckProfilePicture = $duckProfilePicture;
    }

    public function getDuckID(): ?int
    {
        return $this->duckID;
    }

    public function setDuckID(?int $duckID): void
    {
        $this->duckID = $duckID;
    }

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: 'string')]
    private ?string $author = null;
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $imgSrc = null;
    #[ORM\Column(length: 500)]
    private ?string $tags = null;
    #[ORM\OneToMany(mappedBy: 'parentId', targetEntity: self::class)]
    private Collection $comments;
    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'comments')]
    private  ?self $parentId =null;

    #[ORM\Column]
    private ?bool $Display = null;

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    public function getImgSrc(): ?string
    {
        return $this->imgSrc;
    }

    public function setImgSrc(?string $imgSrc): void
    {
        $this->imgSrc = $imgSrc;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): void
    {
        $this->tags = $tags;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->Display = true;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getParentsId(): ?self
    {
        return $this->parentId;
    }

    public function setParentId(?self $parentId): static
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComments(self $comments): static
    {
        if (!$this->comments->contains($comments)) {
            $this->comments->add($comments);
            $comments->setParentId($this);
        }

        return $this;
    }

    public function removeComments(self $comments): static
    {
        if ($this->parentId->removeElement($comments)) {
            // set the owning side to null (unless already changed)
            if ($comments->getParentsId() === $this) {
                $comments->setParentId(null);
            }
        }

        return $this;
    }

    public function isDisplay(): ?bool
    {
        return $this->Display;
    }

    public function setDisplay(bool $Display): static
    {
        $this->Display = $Display;

        return $this;
    }
}
