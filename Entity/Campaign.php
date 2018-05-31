<?php

namespace Octopouce\AdvertisingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Campaign
 *
 * @ORM\Table(name="adv_campaign")
 * @ORM\Entity()
 */
class Campaign
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
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="start_date", type="datetime")
	 */
	private $startDate;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="end_date", type="datetime")
	 */
	private $endDate;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="text", nullable=true)
	 */
	private $description;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Advert", mappedBy="campaign", cascade={"persist", "remove"})
	 */
	private $adverts;


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
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Campaign
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set startDate
	 *
	 * @param \DateTime $startDate
	 *
	 * @return Campaign
	 */
	public function setStartDate($startDate)
	{
		if(is_string($startDate) && $startDate){
			$startDate = new \DateTime($startDate);
		}
		$this->startDate = $startDate;

		return $this;
	}

	/**
	 * Get startDate
	 *
	 * @return \DateTime
	 */
	public function getStartDate()
	{
		return $this->startDate;
	}

	/**
	 * Set endDate
	 *
	 * @param \Datetime $endDate
	 *
	 * @return Campaign
	 */
	public function setEndDate($endDate)
	{
		if(is_string($endDate) && $endDate){
			$endDate = new \DateTime($endDate);
		}
		$this->endDate = $endDate;

		return $this;
	}

	/**
	 * Get endDate
	 *
	 * @return \Datetime
	 */
	public function getEndDate()
	{
		return $this->endDate;
	}

	/**
	 * Set description
	 *
	 * @param string $description
	 *
	 * @return Campaign
	 */
	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * Get description
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param ArrayCollection $adverts
	 */
	public function addAdverts($adverts)
	{
		$this->adverts[] = $adverts;
	}

	/**
	 * Remove advert
	 *
	 * @param Advert $advert
	 */
	public function removeAdvert(Advert $advert)
	{
		$this->adverts->removeElement($advert);
	}

	/**
	 * @return ArrayCollection
	 */
	public function getAdverts()
	{
		return $this->adverts;
	}
}

