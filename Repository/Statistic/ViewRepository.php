<?php

namespace Octopouce\AdvertisingBundle\Repository\Statistic;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Octopouce\AdvertisingBundle\Entity\Statistic\View;

class ViewRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, View::class);
	}

	public function findByAdverts(array $adverts, $start = null, $end = null, $adzone = null){
		$qb = $this->createQueryBuilder('v')
					->select('SUM(v.views)')
		           ->leftJoin('v.advert', 'a');

		foreach ($adverts as $advert){
			$qb->andWhere('a = :advert')
				->setParameter('advert', $advert);
		}

		if($start){
			$qb->andWhere('v.date >= :start')
				->setParameter('start', $start);
		}

		if($end){
			$qb->andWhere('v.date < :end')
			   ->setParameter('end', $end);
		}

		if($adzone){
			$qb->andWhere('v.adzone = :adzone')
			   ->setParameter('adzone', $adzone);
		}

		return $qb->getQuery()->getSingleScalarResult();
	}

	public function findByAdzone($adzone, $start = null, $end = null){
		$qb = $this->createQueryBuilder('v')
		           ->select('SUM(v.views)')
		           ->leftJoin('v.adzone', 'a');

		$qb->where('a = :adzone')
		   ->setParameter('adzone', $adzone);

		if($start){
			$qb->andWhere('v.date >= :start')
			   ->setParameter('start', $start);
		}

		if($end){
			$qb->andWhere('v.date < :end')
			   ->setParameter('end', $end);
		}

		return $qb->getQuery()->getSingleScalarResult();
	}

	public function findByCampaigns(array $campaigns, $start = null, $end = null, $adzone = null){
		$qb = $this->createQueryBuilder('v')
		           ->select('SUM(v.views)')
		           ->leftJoin('v.advert', 'a')
		           ->leftJoin('a.campaign', 'c');

		foreach ($campaigns as $campaign){
			$qb->andWhere('c = :campaign')
			   ->setParameter('campaign', $campaign);
		}

		if($start){
			$qb->andWhere('v.date >= :start')
			   ->setParameter('start', $start);
		}

		if($end){
			$qb->andWhere('v.date < :end')
			   ->setParameter('end', $end);
		}

		if($adzone){
			$qb->andWhere('v.adzone = :adzone')
			   ->setParameter('adzone', $adzone);
		}

		return $qb->getQuery()->getSingleScalarResult();
	}

}
