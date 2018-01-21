<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Movie", inversedBy="comments")
     */
    private $movie;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="comments")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var boolean
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;

    /**
     * @var bool
     * @ORM\Column(name="signaled", type="boolean")
     */
    private $signaled = false;

    /**
     * Comment constructor.
     * @param $movie
     * @param $user
     */
    public function __construct(Movie $movie, User $user)
    {
        $this->movie = $movie;
        $this->user = $user;
        $this->createdAt = new \DateTime('now');
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMovie()
    {
        return $this->movie;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Comment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @param bool $published
     * @return Comment
     */
    public function setPublished(bool $published): Comment
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSignaled()
    {
        return $this->signaled;
    }

    /**
     * @param bool $signaled
     * @return Comment
     */
    public function setSignaled(bool $signaled)
    {
        $this->signaled = $signaled;

        return $this;
    }
}

