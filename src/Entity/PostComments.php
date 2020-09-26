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
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="postComments")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=2000)
     */
    private $comment;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isHidden;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?BlogPosts
    {
        return $this->post;
    }

    public function setPost(?BlogPosts $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

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

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }
}
