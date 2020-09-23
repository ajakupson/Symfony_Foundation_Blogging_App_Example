<?php

namespace App\Entity;

use App\Repository\BlogPostsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogPostsRepository::class)
 */
class BlogPosts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $userId;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $postImg;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity=PostComments::class, mappedBy="postId")
     */
    private $postComments;

    public function __construct()
    {
        $this->postComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
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

    public function getPostImg(): ?string
    {
        return $this->postImg;
    }

    public function setPostImg(?string $postImg): self
    {
        $this->postImg = $postImg;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection|PostComments[]
     */
    public function getPostComments(): Collection
    {
        return $this->postComments;
    }

    public function addPostComment(PostComments $postComment): self
    {
        if (!$this->postComments->contains($postComment)) {
            $this->postComments[] = $postComment;
            $postComment->setPostId($this);
        }

        return $this;
    }

    public function removePostComment(PostComments $postComment): self
    {
        if ($this->postComments->contains($postComment)) {
            $this->postComments->removeElement($postComment);
            // set the owning side to null (unless already changed)
            if ($postComment->getPostId() === $this) {
                $postComment->setPostId(null);
            }
        }

        return $this;
    }
}
