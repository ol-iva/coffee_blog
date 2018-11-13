<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title = 'Title of your new article';

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $slug = 'coffee-is-the-best-your-choice';

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="articles")
     */
    private $category;

//    /**
//     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="articles")
//     */
//    private $author;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="authorArticles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageNumber;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedAt;

//    public function __construct()
//    {
//        $this->publishedAt = new \DateTime();
//    }
    public function __toString()
    {
        return $this->title ? $this->title : 'New article';
    }

    /**
     * @ORM\PrePersist()
     */
    public function setPublishedAtValue()
    {
        $this->publishedAt = new \DateTime();

        return $this;
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

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

    public function getImageNumber(): ?string
    {
        return $this->imageNumber;
    }

    public function setImageNumber($imageNumber): self
    {
        $this->imageNumber = $imageNumber;

        return $this;
    }

}
