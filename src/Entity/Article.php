<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="articles")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="authorArticles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    private $imageFile;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedAt;

    public function __construct()
    {
        $this->publishedAt = new \DateTime();
    }

    public function __toString()
    {
        return $this->title ? $this->title : 'New article';
    }

    public function imageUpload()
    {
        $file = $this->getImageFile();

        if (!$file || !$file instanceof UploadedFile) {
//            $this->setImage(null);
            return;
        }
        $fileName = uniqid() . '.' . $file->guessExtension();

        try {
            $file->move(
                realpath('images'),
                $fileName
            );
            $this->trashImage();

            $this->setImage($fileName);

        } catch (FileException $exception) {
            // handle exception
        }
    }

//    /**
//     * @ORM/PostRemove
//     */
    public function trashImage()
    {
        $oldFile = realpath('images') . '/' . $this->getImage();

        if (is_file($oldFile)) {
            unlink($oldFile);
        }
    }

    public function getImagePath()
    {
        if ($this->getImage()) {
            return "/images/{$this->getImage()}";
        };
        return "/images/1.jpg";
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

    public function uploadSlug(ArticleRepository $articleRepository): ?string
    {
        $slugTemporary = preg_replace('/\s+/', '-', mb_strtolower($this->getTitle()));
        $slug = $slugTemporary;
        $n = 1;

        while ($articleRepository->findOneBy(['slug' => $slug])) {
            $slug = $slugTemporary . '-' . $n;
            $n = $n + 1;
        };
        return $slug;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage($imageNumber): self
    {
        $this->image = $imageNumber;

        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile($imageFile): void
    {
        $this->imageFile = $imageFile;
    }
}