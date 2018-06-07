<?php

namespace Octopouce\AdvertisingBundle\Entity\Statistic;

use Doctrine\ORM\Mapping as ORM;


/**
 * Click
 *
 * @ORM\Table(name="adv_stat_click")
 * @ORM\Entity(repositoryClass="Octopouce\AdvertisingBundle\Repository\Statistic\ClickRepository")
 */
class Click
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
	 * @var \DateTime
	 *
	 * @ORM\Column(name="date", type="date")
	 */
	private $date;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="clicks", type="integer")
	 */
	private $clicks;

	/**
	 * @var \Octopouce\AdvertisingBundle\Entity\Advert
	 *
	 * @ORM\ManyToOne(targetEntity="Octopouce\AdvertisingBundle\Entity\Advert", inversedBy="statsClick")
	 * @ORM\JoinColumn(name="advert_id", referencedColumnName="id")
	 */
	private $advert;

	/**
	 * @var \Octopouce\AdvertisingBundle\Entity\Adzone
	 *
	 * @ORM\ManyToOne(targetEntity="Octopouce\AdvertisingBundle\Entity\Adzone", inversedBy="statsClick")
	 * @ORM\JoinColumn(name="adzone_id", referencedColumnName="id")
	 */
	private $adzone;

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
	 * @return Click
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
	 * Set clicks
	 *
	 * @param integer $clicks
	 *
	 * @return Click
	 */
	public function setClicks($clicks)
	{
		$this->clicks = $clicks;

		return $this;
	}

	/**
	 * Get clicks
	 *
	 * @return int
	 */
	public function getClicks()
	{
		return $this->clicks;
	}

	/**
	 * Increment clicks
	 *
	 * @return Click
	 */
	public function incrementClicks()
	{
		$this->clicks = $this->clicks + 1;

		return $this;
	}

	/**
	 * Set advert
	 *
	 * @param \Octopouce\AdvertisingBundle\Entity\Advert $advert
	 *
	 * @return Click
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
	 * @return Click
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