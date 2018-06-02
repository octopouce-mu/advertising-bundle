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

	public function findByEnable($enable = true, $sorts = null, $limit = null){
		$qb = $this->createQueryBuilder('c');

		if($enable){
			$qb->where('c.endDate > :now')
			   ->setParameter('now', new \DateTime());
		}else{
			$qb->where('c.endDate <= :now')
			   ->setParameter('now', new \DateTime());
		}


		if($sorts){
			foreach ($sorts as $sort => $order){
				$qb->addOrderBy($sort, $order);
			}
		}

		if($limit){
			$qb->getMaxResults($limit);
		}

		return $qb->getQuery()->getResult();
	}

}
