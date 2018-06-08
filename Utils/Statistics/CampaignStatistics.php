<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 08/06/2018
 */

namespace Octopouce\AdvertisingBundle\Utils\Statistics;


use Doctrine\ORM\EntityManagerInterface;
use Octopouce\AdvertisingBundle\Entity\Statistic\Click;
use Octopouce\AdvertisingBundle\Entity\Statistic\View;

class CampaignStatistics {

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
	private $campaigns = [];

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

		return ['impressions' => $impressions, 'clicks' => $clicks];
	}

	public function byDate($start = null, $end = null) {
		$impressions = $this->getImpressions($start, $end);
		$clicks = $this->getClicks($start, $end);

		return ['impressions' => $impressions, 'clicks' => $clicks];
	}

	public function getImpressions($start = null, $end = null, $adzone = null){
		$start = $start ? $start : $this->getStart();
		$end = $end ? $end : $this->getEnd();

		$impressions = $this->em->getRepository(View::class)->findByCampaigns($this->getCampaigns(), $start, $end, $adzone);

		return $impressions ? $impressions : 0;
	}

	public function getClicks($start = null, $end = null, $adzone = null){
		$start = $start ? $start : $this->getStart();
		$end = $end ? $end : $this->getEnd();

		$clicks = $this->em->getRepository(Click::class)->findByCampaigns($this->getCampaigns(), $start, $end, $adzone);

		return $clicks ? $clicks : 0;
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
	public function getCampaigns(): array {
		return $this->campaigns;
	}

	/**
	 * @param array $campaigns
	 */
	public function setCampaigns( array $campaigns ): void {
		$this->campaigns = $campaigns;
	}
}