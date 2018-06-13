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

	public function findByActive($active = true, $sorts = null, $limit = null, $adzone = null){
		$qb = $this->createQueryBuilder('a')
		           ->leftJoin('a.campaign', 'c');

		if($active){
			$qb->where('c.endDate > :now');
		}else{
			$qb->where('c.endDate <= :now');
		}
	    $qb->setParameter('now', new \DateTime());

		if($adzone){
			$qb->leftJoin('a.adzones', 'adz')
			   ->andWhere('adz.id = :adzone')
			   ->setParameter('adzone', $adzone->getId());
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
