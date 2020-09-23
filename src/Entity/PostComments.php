<?php

namespace App\Entity;

use App\Repository\PostCommentsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostCommentsRepository::class)
 */
class PostComments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=BlogPosts::class, inversedBy="postComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $postId;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="postComments")
     */
    private $userId;

    /**
     * @ORM\Column(type="string", length=2000)
     */
    private $comment;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isHidden;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostId(): ?BlogPosts
    {
        return $this->postId;
    }

    public function setPostId(?BlogPosts $postId): self
    {
        $this->postId = $postId;

        return $this;
    }

    public function getUserId(): ?Users
    {
        return $this->userId;
    }

    public function setUserId(?Users $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getIsHidden(): ?bool
    {
        return $this->isHidden;
    }

    public function setIsHidden(bool $isHidden): self
    {
        $this->isHidden = $isHidden;

        return $this;
    }
}
