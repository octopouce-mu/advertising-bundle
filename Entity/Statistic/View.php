<?php

namespace Octopouce\AdvertisingBundle\Entity\Statistic;

use Doctrine\ORM\Mapping as ORM;

use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * view
 *
 * @ORM\Table(name="adv_stat_view")
 * @ORM\Entity()
 */
class View
{
    use ORMBehaviors\Timestampable\Timestampable;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="views", type="integer")
     */
    private $views;

    /**
     * @var \Octopouce\AdvertisingBundle\Entity\Advert
     *
     * @ORM\ManyToOne(targetEntity="Octopouce\AdvertisingBundle\Entity\Advert", inversedBy="statsView")
     * @ORM\JoinColumn(name="advert_id", referencedColumnName="id")
     */
    private $advert;

    /**
     * @var \Octopouce\AdvertisingBundle\Entity\Adzone
     *
     * @ORM\ManyToOne(targetEntity="Octopouce\AdvertisingBundle\Entity\Adzone", inversedBy="statsView")
     * @ORM\JoinColumn(name="adzone_id", referencedColumnName="id")
     */
    private $adzone;


    public function __construct() {
        $this->date = new \DateTime();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return View
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set views
     *
     * @param integer $views
     *
     * @return View
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Increment views
     *
     * @return View
     */
    public function incrementViews()
    {
        $this->views = $this->views + 1;

        return $this;
    }

    /**
     * Get views
     *
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set advert
     *
     * @param \Octopouce\AdvertisingBundle\Entity\Advert $advert
     *
     * @return View
     */
    public function setAdvert(\Octopouce\AdvertisingBundle\Entity\Advert $advert = null)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \Octopouce\AdvertisingBundle\Entity\Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * Set adzone
     *
     * @param \Octopouce\AdvertisingBundle\Entity\Adzone $adzone
     *
     * @return View
     */
    public function setAdzone(\Octopouce\AdvertisingBundle\Entity\Adzone $adzone = null)
    {
        $this->adzone = $adzone;

        return $this;
    }

    /**
     * Get adzone
     *
     * @return \Octopouce\AdvertisingBundle\Entity\Adzone
     */
    public function getAdzone()
    {
        return $this->adzone;
    }
}

