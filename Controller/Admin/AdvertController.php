<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 01/06/2018
 */

namespace Octopouce\AdvertisingBundle\Controller\Admin;

use Octopouce\AdvertisingBundle\Entity\Advert;
use Octopouce\AdvertisingBundle\Entity\Adzone;
use Octopouce\AdvertisingBundle\Entity\Campaign;
use Octopouce\AdvertisingBundle\Form\AdvertType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/advert")
 */
class AdvertController extends Controller
{
	/**
	 * @Route("/", name="octopouce_advertising_admin_advert_index")
	 */
	public function index() : Response {
		$adverts = $this->getDoctrine()->getRepository(Advert::class)->findByActive(true, ['c.startDate'=>'ASC']);

		return $this->render('@OctopouceAdvertising/Admin/Advert/index.html.twig', [
			'adverts' => $adverts
		]);
	}

	/**
	 * @Route("/old", name="octopouce_advertising_admin_advert_old")
	 */
	public function old() : Response {
		$adverts = $this->getDoctrine()->getRepository(Advert::class)->findByInactive(false, ['c.endDate'=>'DESC']);

		return $this->render('@OctopouceAdvertising/Admin/Advert/old.html.twig', [
			'adverts' => $adverts
		]);
	}

	/**
	 * @Route("/create", name="octopouce_advertising_admin_advert_create")
	 */
	public function create(Request $request) : Response {
		$em = $this->getDoctrine()->getManager();

		$campaignId = $request->get('campaign');
		$campaign = $em->getRepository(Campaign::class)->find($campaignId);

		$adzoneId = $request->get('adzone');
		$adzone = $em->getRepository(Adzone::class)->find($adzoneId);

		$advert = new Advert();

		$form = $this->createForm(AdvertType::class, $advert);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em->persist($advert);
			$em->flush();

			return $this->redirectToRoute('admin_event_index');
		}

		return $this->render('@OctopouceAdvertising/Admin/Advert/create.html.twig', [
			'advert' => $advert
		]);
	}
}