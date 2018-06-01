<?php

namespace Octopouce\AdvertisingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Adzone
 *
 * @ORM\Table(name="adv_adzone")
 * @ORM\Entity(repositoryClass="Octopouce\AdvertisingBundle\Repository\AdzoneRepository")
 */
class Adzone
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
	 * @var int
	 *
	 * @ORM\Column(name="height", type="integer")
	 */
	private $height;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="width", type="integer")
	 */
	private $width;

	/**
	 * Many Adzones have Many Adverts.
	 *
	 * @ORM\ManyToMany(targetEntity="Advert", inversedBy="adzones", cascade={"persist"})
	 * @ORM\JoinTable(name="adv_adzones_adverts")
	 */
	private $adverts;

	/**
	 * Many Adzones have Many Pages.
	 *
	 * @ORM\ManyToMany(targetEntity="Page", inversedBy="adzones", cascade={"persist"})
	 * @ORM\JoinTable(name="adv_adzones_pages")
	 */
	private $pages;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Octopouce\AdvertisingBundle\Entity\Statistic\View", mappedBy="adzone", cascade={"persist", "remove"})
	 */
	private $statsView;


	public function __construct() {
		$this->adverts = new ArrayCollection();
		$this->pages = new ArrayCollection();
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
	 * @return Adzone
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
	 * Set height
	 *
	 * @param integer $height
	 *
	 * @return Adzone
	 */
	public function setHeight($height)
	{
		$this->height = $height;

		return $this;
	}

	/**
	 * Get height
	 *
	 * @return int
	 */
	public function getHeight()
	{
		return $this->height;
	}

	/**
	 * Get totalViews
	 *
	 * @return int
	 */
	public function getTotalViews()
	{
		$total = 0;
		$views = $this->getStatsView();

		foreach ($views as $view){
			$total += $view->getViews();
		}

		return $total;
	}

	/**
	 * Set width
	 *
	 * @param integer $width
	 *
	 * @return Adzone
	 */
	public function setWidth($width)
	{
		$this->width = $width;

		return $this;
	}

	/**
	 * Get width
	 *
	 * @return int
	 */
	public function getWidth()
	{
		return $this->width;
	}

	/**
	 * Add advert
	 *
	 * @param Advert $advert
	 *
	 * @return Adzone
	 */
	public function addAdvert(Advert $advert)
	{
		$this->adverts[] = $advert;

		return $this;
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
	 * Get adverts
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getAdverts()
	{
		return $this->adverts;
	}

	/**
	 * Add page
	 *
	 * @param Page $page
	 *
	 * @return Adzone
	 */
	public function addPage(Page $page)
	{
		$this->pages[] = $page;

		return $this;
	}

	/**
	 * Remove page
	 *
	 * @param Page $page
	 */
	public function removePage(Page $page)
	{
		$this->pages->removeElement($page);
	}

	/**
	 * Get pages
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getPages()
	{
		return $this->pages;
	}


	/**
	 * Add statsView.
	 *
	 * @param \Octopouce\AdvertisingBundle\Entity\Statistic\View $statsView
	 *
	 * @return Adzone
	 */
	public function addStatsView(\Octopouce\AdvertisingBundle\Entity\Statistic\View $statsView)
	{
		$this->statsView[] = $statsView;

		return $this;
	}

	/**
	 * Remove statsView.
	 *
	 * @param \Octopouce\AdvertisingBundle\Entity\Statistic\View $statsView
	 *
	 * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
	 */
	public function removeStatsView(\Octopouce\AdvertisingBundle\Entity\Statistic\View $statsView)
	{
		return $this->statsView->removeElement($statsView);
	}

	/**
	 * Get statsView.
	 *
	 * @return ArrayCollection
	 */
	public function getStatsView()
	{
		return $this->statsView;
	}


}