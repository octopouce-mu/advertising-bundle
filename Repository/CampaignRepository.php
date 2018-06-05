<?php

namespace Octopouce\AdvertisingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Octopouce\AdvertisingBundle\Entity\Campaign;

class CampaignRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Campaign::class);
	}

	private function setAdditonnal($qb, $sorts, $limit){
		if($sorts){
			foreach ($sorts as $sort => $order){
				$qb->addOrderBy($sort, $order);
			}
		}

		if($limit) $qb->getMaxResults($limit);

		return $qb;
	}

	public function findByPassed($sorts = null, $limit = null){
		$qb = $this->createQueryBuilder('c');

		$qb->where('c.endDate <= :now')
		   ->setParameter('now', new \DateTime());

		$qb = $this->setAdditonnal($qb, $sorts, $limit);

		return $qb->getQuery()->getResult();
	}

	public function findByActive($sorts = null, $limit = null){
		$qb = $this->createQueryBuilder('c');

		$qb->where('c.endDate > :now')
			->andWhere('c.startDate <= :now')
		   ->setParameter('now', new \DateTime());

		$qb = $this->setAdditonnal($qb, $sorts, $limit);

		return $qb->getQuery()->getResult();
	}

	public function findByFuture($sorts = null, $limit = null){
		$qb = $this->createQueryBuilder('c');

		$qb->where('c.startDate > :now')
		   ->setParameter('now', new \DateTime());

		$qb = $this->setAdditonnal($qb, $sorts, $limit);

		return $qb->getQuery()->getResult();
	}

}
