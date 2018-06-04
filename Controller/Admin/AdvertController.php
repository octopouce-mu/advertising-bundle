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
use Octopouce\AdvertisingBundle\Service\FileUploader;
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
	 * @Route("/{advert}/show", name="octopouce_advertising_admin_advert_show")
	 */
	public function show(Advert $advert) : Response {
		$em = $this->getDoctrine()->getManager();

		return $this->render('@OctopouceAdvertising/Admin/Advert/show.html.twig', [
			'advert' => $advert
		]);
	}

	/**
	 * @Route("/create", name="octopouce_advertising_admin_advert_create")
	 */
	public function create(Request $request, FileUploader $fileUploader) : Response {
		$em = $this->getDoctrine()->getManager();

		$campaignId = $request->get('campaign');
		$campaign = $em->getRepository(Campaign::class)->find($campaignId);

		$adzoneId = $request->get('adzone');
		$adzone = $em->getRepository(Adzone::class)->find($adzoneId);

		$advert = new Advert();
		$advert->setCampaign($campaign);
		$advert->addAdzone($adzone);

		$form = $this->createForm(AdvertType::class, $advert);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em->persist($advert);
			$em->flush();

			$imgDesktop = $advert->getImageDesktop();
			$imgDesktopName = $fileUploader->upload($imgDesktop, 'adv/'.$advert->getId());
			$advert->setImageDesktop($imgDesktopName);

			$imgTablet = $advert->getImageTablet();
			$imgTabletName = $fileUploader->upload($imgTablet, 'adv/'.$advert->getId());
			$advert->setImageTablet($imgTabletName);

			$imgMobile = $advert->getImageMobile();
			$imgMobileName = $fileUploader->upload($imgMobile, 'adv/'.$advert->getId());
			$advert->setImageMobile($imgMobileName);


			$em->persist($advert);
			$em->flush();

			return $this->redirectToRoute('octopouce_advertising_admin_campaign_show', ['campaign'=>$campaignId]);
		}

		return $this->render('@OctopouceAdvertising/Admin/Advert/create.html.twig', [
			'advert' => $advert,
			'campaign' => $campaign,
			'adzone' => $adzone,
			'form' => $form->createView()
		]);
	}
}