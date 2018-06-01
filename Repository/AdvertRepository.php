<?php

namespace Octopouce\AdvertisingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Octopouce\AdvertisingBundle\Entity\Advert;

class AdvertRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Advert::class);
	}

	public function findByActive($sorts = null){
		$qb = $this->createQueryBuilder('a')
		           ->leftJoin('a.campaign', 'c')
		           ->where('c.endDate > :now')
					->setParameter('now', new \DateTime());

		if($sorts){
			foreach ($sorts as $sort => $order){
				$qb->addOrderBy($sort, $order);
			}
		}


		return $qb->getQuery()->getResult();
	}


}
