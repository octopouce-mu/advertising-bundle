<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 08/06/2018
 */

namespace Octopouce\AdvertisingBundle\Twig;


use Doctrine\ORM\EntityManagerInterface;
use Octopouce\AdvertisingBundle\Entity\Advert;
use Octopouce\AdvertisingBundle\Entity\Adzone;
use Octopouce\AdvertisingBundle\Entity\Statistic\View;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AdvertExtension extends AbstractExtension {

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * @var RequestStack
	 */
	private $request;

	/**
	 * AdvertExtension constructor.
	 *
	 * @param EntityManagerInterface $em
	 * @param RequestStack $request
	 */
	public function __construct( EntityManagerInterface $em, RequestStack $request)
	{
		$this->em = $em;
		$this->request = $request;
	}


	public function getFunctions(): array
	{
		return [
			new TwigFunction('adzone', [$this, 'showAdzone'])
		];
	}

	public function showAdzone($adzoneName)
	{

		$route = $this->request->getCurrentRequest()->get('_route');
		if($route === 'homepage') $route = 'home_index';

		$adzone = $this->em->getRepository(Adzone::class)->findOneByPageByAdzone($route, $adzoneName);
		if(!$adzone){
			return ['adzone' => null, 'adverts' => []];
		}

		$adverts = $this->em->getRepository(Advert::class)->findByActive(true, null, null, $adzone);
		if($adverts){
			return ['adzone' => $adzone, 'adverts' => $adverts];
		}else{
			return ['adzone' => $adzone, 'adverts' => []];
		}

	}
}