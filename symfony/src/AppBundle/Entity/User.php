<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 * @Vich\Uploadable
 */
class User extends BaseUser
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @var File
     * @Vich\UploadableField(mapping="user_avatar", fileNameProperty="avatar")
     */
    private $avatarFile;

    /**
     * @var string
     * @ORM\Column(name="background", type="string", length=255)
     */
    private $background = 'random';

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Movie", mappedBy="usersLiked")
     * @ORM\JoinTable("liked_movies")
     *
     */
    private $moviesLiked;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->createdAt = new \DateTime();
        $this->moviesLiked = new ArrayCollection();
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar( $avatar )
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param File $file
     */
    public function setAvatarFile( File $file = null ): User
    {
        $this->avatarFile = $file;

        if ($file) {
            $this->setUpdatedAt();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getAvatarFile()
    {
        return $this->avatarFile;
    }

    /**
     * @param string $background
     * @return User
     */
    public function setBackground( string $background ): User
    {
        $this->background = $background;

        return $this;
    }

    /**
     * @return string
     */
    public function getBackground(): string
    {
        return $this->background;
    }

    /**
     * @param \DateTime $updatedAt
     */
    private function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Add moviesLiked
     *
     * @param \AppBundle\Entity\Movie $moviesLiked
     *
     * @return User
     */
    public function addMoviesLiked(\AppBundle\Entity\Movie $moviesLiked)
    {
        $this->moviesLiked[] = $moviesLiked;

        return $this;
    }

    /**
     * Remove moviesLiked
     *
     * @param \AppBundle\Entity\Movie $moviesLiked
     */
    public function removeMoviesLiked(\AppBundle\Entity\Movie $moviesLiked)
    {
        $this->moviesLiked->removeElement($moviesLiked);
    }

    /**
     * Get moviesLiked
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMoviesLiked()
    {
        return $this->moviesLiked;
    }
}
