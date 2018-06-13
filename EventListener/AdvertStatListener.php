<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 08/06/2018
 */

namespace Octopouce\AdvertisingBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Octopouce\AdvertisingBundle\Entity\Advert;
use Octopouce\AdvertisingBundle\Entity\Page;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class AdvertStatListener {

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * AdvertStatListener constructor.
	 *
	 * @param EntityManagerInterface $em
	 */
	public function __construct( EntityManagerInterface $em ) {
		$this->em = $em;
	}


	public function onKernelController(FilterControllerEvent $event)
	{
		$request = $event->getRequest();

		// Matched route
		$route  = $request->attributes->get('_route');

//		/** @var Page $page */
//		$page = $this->em->getRepository(Page::class)->findOneByPath($route);
//		if(!$page)
//			return;
//
//		foreach ($page->getAdzones() as $adzone){
//			$advert = $this->em->getRepository(Advert::class)->find
//		}


	}
}