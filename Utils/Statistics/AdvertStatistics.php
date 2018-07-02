<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 06/06/2018
 */

namespace Octopouce\AdvertisingBundle\Utils\Statistics;


use Doctrine\ORM\EntityManagerInterface;
use Octopouce\AdvertisingBundle\Entity\Advert;
use Octopouce\AdvertisingBundle\Entity\Adzone;
use Octopouce\AdvertisingBundle\Entity\Statistic\Click;
use Octopouce\AdvertisingBundle\Entity\Statistic\View;

class AdvertStatistics {

	/**
	 * @var \DateTime
	 */
	private $start;

	/**
	 * @var \DateTime
	 */
	private $end;

	/**
	 * @var array
	 */
	private $adverts = [];

	/** @var Adzone */
	private $adzone;

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * AdvertStatistics constructor.
	 */
	public function __construct(EntityManagerInterface $em) {
		$this->em = $em;
		$this->start = new \DateTime('today');
		$this->end = new \DateTime('tomorrow');

	}

	public function getToday(){
		$impressions = $this->getImpressions();
		$clicks = $this->getClicks();

		return ['impressions' => $this->getTotal($impressions), 'clicks' => $this->getTotal($clicks)];
	}

	public function byDate($start = null, $end = null) {
		$impressions = $this->getImpressions($start, $end);
		$clicks = $this->getClicks($start, $end);

		return ['impressions' => $this->getTotal($impressions), 'clicks' => $this->getTotal($clicks), 'days'=>['impressions'=>$impressions, 'clicks'=>$clicks]];
	}

	public function getImpressions($start = null, $end = null, $adzone = null){
		$start = $start ? $start : $this->getStart();
		$end = $end ? $end : $this->getEnd();
		$adzone = $adzone ? $adzone : $this->getAdzone();

		$impressions = $this->em->getRepository(View::class)->findByAdverts($this->getAdverts(), $start, $end, $adzone);

		return $impressions;
	}

	public function getClicks($start = null, $end = null, $adzone = null){
		$start = $start ? $start : $this->getStart();
		$end = $end ? $end : $this->getEnd();
		$adzone = $adzone ? $adzone : $this->getAdzone();

		$clicks = $this->em->getRepository(Click::class)->findByAdverts($this->getAdverts(), $start, $end, $adzone);

		return $clicks;
	}

	public function getTotal($entities){
		$cpt = 0;

		foreach ($entities as $entity){
			if($entity instanceof View){
				$cpt += $entity->getViews();
			}elseif($entity instanceof Click){
				$cpt += $entity->getClicks();
			}
		}
		return $cpt;
	}


	/**
	 * @return \DateTime
	 */
	public function getStart(): \DateTime {
		return $this->start;
	}

	/**
	 * @param \DateTime $start
	 */
	public function setStart( \DateTime $start ): void {
		$this->start = $start;
	}

	/**
	 * @return \DateTime
	 */
	public function getEnd(): \DateTime {
		return $this->end;
	}

	/**
	 * @param \DateTime $end
	 */
	public function setEnd( \DateTime $end ): void {
		$this->end = $end;
	}

	/**
	 * @return array
	 */
	public function getAdverts(): array {
		return $this->adverts;
	}

	/**
	 * @param Advert $advert
	 */
	public function addAdvert( Advert $advert ): void {
		$this->adverts[] = $advert;
	}

	/**
	 * @param array $adverts
	 */
	public function setAdverts( array $adverts ): void {
		$this->adverts = $adverts;
	}

	/**
	 * @return Adzone
	 */
	public function getAdzone() {
		return $this->adzone;
	}

	/**
	 * @param Adzone $adzone
	 */
	public function setAdzone( Adzone $adzone ): void {
		$this->adzone = $adzone;
	}




}