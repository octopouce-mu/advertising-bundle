<?php

namespace Octopouce\AdvertisingBundle\Entity\Statistic;

use Doctrine\ORM\Mapping as ORM;

use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Click
 *
 * @ORM\Table(name="adv_stat_click")
 * @ORM\Entity()
 */
class Click
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
}