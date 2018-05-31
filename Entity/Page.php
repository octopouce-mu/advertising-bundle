<?php

namespace Octopouce\AdvertisingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table(name="adv_page")
 * @ORM\Entity()
 */
class Page
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
	 * Many Pages have Many Adzones.
	 *
	 * @ORM\ManyToMany(targetEntity="Adzone", mappedBy="pages")
	 */
	private $adzones;

	public function __construct() {
		$this->adzones = new ArrayCollection();
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
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Page
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
	 * Add adzone
	 *
	 * @param Adzone $adzone
	 *
	 * @return Page
	 */
	public function addAdzone(Adzone $adzone)
	{
		$this->adzones[] = $adzone;

		return $this;
	}

	/**
	 * Remove adzone
	 *
	 * @param Adzone $adzone
	 */
	public function removeAdzone(Adzone $adzone)
	{
		$this->adzones->removeElement($adzone);
	}

	/**
	 * Get adzones
	 *
	 * @return ArrayCollection
	 */
	public function getAdzones()
	{
		return $this->adzones;
	}
}

