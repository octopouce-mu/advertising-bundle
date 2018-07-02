<?php

namespace Octopouce\AdvertisingBundle\Repository\Statistic;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Octopouce\AdvertisingBundle\Entity\Statistic\Click;

class ClickRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Click::class);
	}

	public function findByAdverts(array $adverts, $start = null, $end = null, $adzone = null){
		$qb = $this->createQueryBuilder('c')
		           ->leftJoin('c.advert', 'a');

		foreach ($adverts as $advert){
			$qb->andWhere('a = :advert')
				->setParameter('advert', $advert);
		}

		if($start){
			$qb->andWhere('c.date >= :start')
				->setParameter('start', $start);
		}

		if($end){
			$qb->andWhere('c.date < :end')
			   ->setParameter('end', $end);
		}

		if($adzone){
			$qb->andWhere('c.adzone = :adzone')
			   ->setParameter('adzone', $adzone);
		}

		return $qb->getQuery()->getResult();
	}

	public function findByAdzone($adzone, $start = null, $end = null){
		$qb = $this->createQueryBuilder('c')
		           ->select('SUM(c.clicks)')
		           ->leftJoin('c.adzone', 'a');

		$qb->where('a = :adzone')
		   ->setParameter('adzone', $adzone);

		if($start){
			$qb->andWhere('c.date >= :start')
			   ->setParameter('start', $start);
		}

		if($end){
			$qb->andWhere('c.date < :end')
			   ->setParameter('end', $end);
		}

		return $qb->getQuery()->getSingleScalarResult();
	}

	public function findByCampaigns(array $campaigns, $start = null, $end = null, $adzone = null){
		$qb = $this->createQueryBuilder('c')
		           ->select('SUM(c.clicks)')
		           ->leftJoin('c.advert', 'a')
		           ->leftJoin('a.campaign', 'ca');

		foreach ($campaigns as $campaign){
			$qb->andWhere('ca = :campaign')
			   ->setParameter('campaign', $campaign);
		}

		if($start){
			$qb->andWhere('c.date >= :start')
			   ->setParameter('start', $start);
		}

		if($end){
			$qb->andWhere('c.date < :end')
			   ->setParameter('end', $end);
		}

		if($adzone){
			$qb->andWhere('c.adzone = :adzone')
			   ->setParameter('adzone', $adzone);
		}

		return $qb->getQuery()->getSingleScalarResult();
	}

}
