<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movie
 *
 * @ORM\Table(name="movie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="releaseDate", type="date")
     */
    private $releaseDate;

    /**
     * @var int
     *
     * @ORM\Column(name="runtime", type="integer")
     */
    private $runtime;

    /**
     * @var string
     *
     * @ORM\Column(name="shortPlot", type="text")
     */
    private $shortPlot;

    /**
     * @var string
     *
     * @ORM\Column(name="longPlot", type="text")
     */
    private $longPlot;

    /**
     * @var string
     *
     * @ORM\Column(name="poster", type="string", length=255)
     */
    private $poster;


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
     * Set title
     *
     * @param string $title
     *
     * @return Movie
     */
    public function setTitle($title)
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
    public function setSlug($slug)
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
    public function setReleaseDate($releaseDate)
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
    public function setRuntime($runtime)
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
     * Set shortPlot
     *
     * @param string $shortPlot
     *
     * @return Movie
     */
    public function setShortPlot($shortPlot)
    {
        $this->shortPlot = $shortPlot;

        return $this;
    }

    /**
     * Get shortPlot
     *
     * @return string
     */
    public function getShortPlot()
    {
        return $this->shortPlot;
    }

    /**
     * Set longPlot
     *
     * @param string $longPlot
     *
     * @return Movie
     */
    public function setLongPlot($longPlot)
    {
        $this->longPlot = $longPlot;

        return $this;
    }

    /**
     * Get longPlot
     *
     * @return string
     */
    public function getLongPlot()
    {
        return $this->longPlot;
    }

    /**
     * Set poster
     *
     * @param string $poster
     *
     * @return Movie
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;

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
}

