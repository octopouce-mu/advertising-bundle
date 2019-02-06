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

	public function findOneByPageByAdzone($route, $adzoneName){
		$qb = $this->createQueryBuilder('a');
		$qb->leftJoin('a.pages', 'p');

		$qb->where('p.path LIKE :route OR p is NULL')
		   ->setParameter('route', $route)
		   ->andWhere('a.name LIKE :adzoneName')
		   ->setParameter('adzoneName', $adzoneName);


		return $qb->getQuery()->getOneOrNullResult();
	}

	public function findByPath($route){
		$qb = $this->createQueryBuilder('a');
		$qb->leftJoin('a.pages', 'p');

		$qb->where('p.path LIKE :route')
			->setParameter('route', $route);


		return $qb->getQuery()->getResult();
	}

	public function findByNotPage(){
		$qb = $this->createQueryBuilder('a');
		$qb->leftJoin('a.pages', 'p');

		$qb->where('p.id IS NULL');


		return $qb->getQuery()->getResult();
	}

}
