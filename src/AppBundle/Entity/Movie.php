<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Genre;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Movie
 *
 * @ORM\Table(name="movie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MovieRepository")
 */
class Movie
{
    const NUM_ITEMS = 20;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="tm_db_id", type="integer")
     */
    private $tmDbId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"}, updatable=false)
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="releaseDate", type="date", nullable=true)
     */
    private $releaseDate;

    /**
     * @var int
     *
     * @ORM\Column(name="runtime", type="integer", nullable=true)
     */
    private $runtime;

    /**
     * @ORM\Column(name="overview", type="text")
     */
    private $overview;

    /**
     * @var string
     *
     * @ORM\Column(name="poster", type="string", length=255, nullable=true)
     */
    private $poster;

    /**
     * @var
     *
     * @ORM\Column(name="popularity", type="float")
     */
    private $popularity;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Genre", inversedBy="movies")
     *
     */
    private $genres;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Notation", mappedBy="movie", cascade={"persist"})
     */
    private $notations;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="movie", cascade={"persist"})
     */
    private $comments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param int $tmDbId
     *
     * @return Movie
     */
    public function setTmDbId( int $tmDbId ): Movie
    {
        $this->tmDbId = $tmDbId;

        return $this;
    }

    /**
     * @return int
     */
    public function getTmDbId(): int
    {
        return $this->tmDbId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Movie
     */
    public function setTitle( $title )
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Movie
     */
    public function setSlug( $slug )
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     *
     * @return Movie
     */
    public function setReleaseDate( $releaseDate )
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set runtime
     *
     * @param integer $runtime
     *
     * @return Movie
     */
    public function setRuntime( $runtime )
    {
        $this->runtime = $runtime;

        return $this;
    }

    /**
     * Get runtime
     *
     * @return int
     */
    public function getRuntime()
    {
        return $this->runtime;
    }


    /**
     * Set overview
     *
     * @param mixed $overview
     * @return Movie
     */
    public function setOverview( $overview )
    {
        $this->overview = $overview;

        return $this;
    }

    /**
     * Get overview
     *
     * @return mixed
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * Set poster
     *
     * @param string $poster
     *
     * @return Movie
     */
    public function setPoster( $poster )
    {
        $this->poster = "https://image.tmdb.org/t/p/w500" . $poster;

        return $this;
    }

    /**
     * Get poster
     *
     * @return string
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * @return mixed
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * @param mixed $popularity
     * @return Movie
     */
    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;
        return $this;
    }

    /**
     * Add genre
     *
     * @param Genre $genre
     *
     * @return Movie
     */
    public function addGenre( Genre $genre )
    {
        $this->genres[] = $genre;

        return $this;
    }

    /**
     * Remove genre
     *
     * @param Genre $genre
     */
    public function removeGenre( Genre $genre )
    {
        $this->genres->removeElement($genre);
    }

    /**
     * Get genres
     *
     * @return Collection
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * Add notation
     *
     * @param \AppBundle\Entity\Notation $notation
     *
     * @return Movie
     */
    public function addNotation(\AppBundle\Entity\Notation $notation)
    {
        $this->notations[] = $notation;

        return $this;
    }

    /**
     * Remove notation
     *
     * @param \AppBundle\Entity\Notation $notation
     */
    public function removeNotation(\AppBundle\Entity\Notation $notation)
    {
        $this->notations->removeElement($notation);
    }

    /**
     * Get notations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotations()
    {
        return $this->notations;
    }
}
