<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 08/06/2018
 */

namespace Octopouce\AdvertisingBundle\Controller;


use Octopouce\AdvertisingBundle\Entity\Advert;
use Octopouce\AdvertisingBundle\Entity\Adzone;
use Octopouce\AdvertisingBundle\Entity\Statistic\Click;
use Octopouce\AdvertisingBundle\Entity\Statistic\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/statistic")
 */
class StatisticController extends Controller
{
	/**
	 * @Route("/add/view", name="octopouce_advertising_statistic_add_view")
	 */
	public function addView(Request $request) : Response
	{
		$adzones = $request->request->get('advs');
		if(!$adzones || count($adzones) === 0){
			return new Response('', 204);
		}

		$em = $this->getDoctrine()->getManager();

		foreach ($adzones as $adzone){
			$adzoneId = str_replace('adzone', '', $adzone['az']);
			$advertId = $adzone['ad'] ? str_replace('advert', '', $adzone['ad']) : null;
			$view = $em->getRepository(View::class)->findOneBy(['adzone' => $adzoneId, 'advert' => $advertId, 'date' => new \DateTime()]);

			if($view) {
				$view->setViews($view->getViews() + 1);
			}else{
				$advert = $adzone['ad'] ? $em->getRepository(Advert::class)->find($advertId) : null;
				$adzone = $em->getRepository(Adzone::class)->find($adzoneId);

				$view = new View();
				$view->setAdvert($advert);
				$view->setViews(1);
				$view->setAdzone($adzone);
				$view->setDate(new \DateTime());
				$em->persist($view);
			}
		}

		$em->flush();

		return new Response('', 204);
	}

	/**
	 * @Route("/add/click", name="octopouce_advertising_statistic_add_click")
	 */
	public function addClick(Request $request) : Response
	{

		$adzone = $request->request->get('adv');

		$em = $this->getDoctrine()->getManager();

		$adzoneId = str_replace('adzone', '', $adzone['az']);
		$advertId = $adzone['ad'] ? str_replace('advert', '', $adzone['ad']) : null;
		$click = $em->getRepository(Click::class)->findOneBy(['adzone' => $adzoneId, 'advert' => $advertId, 'date' => new \DateTime()]);

		if($click) {
			$click->setClick($click->getClick() + 1);
		}else{
			$advert = $adzone['ad'] ? $em->getRepository(Advert::class)->find($advertId) : null;
			$adzone = $em->getRepository(Adzone::class)->find($adzoneId);

			$click = new Click();
			$click->setAdvert($advert);
			$click->setClicks(1);
			$click->setAdzone($adzone);
			$click->setDate(new \DateTime());
			$em->persist($click);
		}

		$em->flush();

		return new Response('', 204);

	}
}