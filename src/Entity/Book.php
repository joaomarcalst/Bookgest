<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private string $title;

    #[Assert\NotBlank]
    #[Assert\Isbn(type: 'isbn13', message: 'Ce champ doit contenir un numéro ISBN valide.')]
    #[ORM\Column(length: 255)]
    private string $isbn;

    #[Assert\NotBlank]
    #[Assert\Url(message: 'Ce champ doit contenir une URL valide.')]
    #[ORM\Column(length: 255)]
    private string $cover;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $editedAt;

    #[Assert\NotBlank]
    #[Assert\Length(min: 10)]
    #[ORM\Column(type: 'text')]
    private string $plot;

    #[Assert\NotBlank]
    #[Assert\Positive]
    #[ORM\Column(type: 'integer')]
    private int $pageNumber;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private string $status;

    #[ORM\ManyToOne(targetEntity: Editor::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editor $editor = null;

    #[ORM\ManyToMany(targetEntity: Author::class, mappedBy: 'books')]
    private Collection $authors;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Comment::class, cascade: ['persist', 'remove'])]
    private Collection $comments;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    // Getters e Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;
        return $this;
    }

    public function getCover(): string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;
        return $this;
    }

    public function getEditedAt(): \DateTimeImmutable
    {
        return $this->editedAt;
    }

    public function setEditedAt(\DateTimeImmutable $editedAt): self
    {
        $this->editedAt = $editedAt;
        return $this;
    }

    public function getPlot(): string
    {
        return $this->plot;
    }

    public function setPlot(string $plot): self
    {
        $this->plot = $plot;
        return $this;
    }

    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    public function setPageNumber(int $pageNumber): self
    {
        $this->pageNumber = $pageNumber;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(?Editor $editor): self
    {
        $this->editor = $editor;
        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors[] = $author;
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        $this->authors->removeElement($author);
        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setBook($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            if ($comment->getBook() === $this) {
                $comment->setBook(null);
            }
        }

        return $this;
    }
}