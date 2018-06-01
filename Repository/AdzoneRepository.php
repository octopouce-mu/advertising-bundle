<?php

namespace Octopouce\AdvertisingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Octopouce\AdvertisingBundle\Entity\Adzone;

class AdzoneRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Adzone::class);
	}

//	public function findAll(){
//		$qb = $this->createQueryBuilder('a')
//		           ->leftJoin('a.statsView', 's')
//		           ->addSelect('SUM(s.views');
//
//
//		return $qb->getQuery()->getResult();
//	}


}
