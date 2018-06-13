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
use Octopouce\AdvertisingBundle\Utils\Statistics\AdvertStatistics;
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
	public function show(Advert $advert, AdvertStatistics $advertStatistics, Request $request) : Response {

		$advertStatistics->addAdvert($advert);

		$start = $request->get('start');
		$end = $request->get('end');

		if(!$start || !$end){
			$start = $advert->getCampaign()->getStartDate();
			$end = $advert->getCampaign()->getEndDate();
		}else {
			$start = new \DateTime($start);
			$end = new \DateTime($end);
			$end->modify('+1 day');
		}

		$stats = $advertStatistics->byDate($start, $end);

		$adzones = [];
		foreach ($advert->getAdzones() as $adzone){
			$advertStatistics->setAdzone($adzone);

			$adzones[] = [
				'adzone' => $adzone,
				'stats' => $advertStatistics->byDate($start, $end)
			];
		}


		return $this->render('@OctopouceAdvertising/Admin/Advert/show.html.twig', [
			'advert' => $advert,
			'stats' => $stats,
			'adzones' => $adzones
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
		$advert->setCampaign($campaign);
		$advert->addAdzone($adzone);

		$form = $this->createForm(AdvertType::class, $advert);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {

			$adzone->addAdvert($advert);

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

	/**
	 * @Route("/{advert}/edit", name="octopouce_advertising_admin_advert_edit")
	 */
	public function edit(Advert $advert, Request $request) : Response {

		$form = $this->createForm(AdvertType::class, $advert);

		$imgDesktopOld = $advert->getImageDesktop();
		$imgTabletOld = $advert->getImageTablet();
		$imgMobileOld = $advert->getImageMobile();

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {


			if(!$advert->getImageDesktop() && $imgDesktopOld) $advert->setImageDesktop($imgDesktopOld->getFileName());
			if(!$advert->getImageTablet() && $imgTabletOld) $advert->setImageTablet($imgTabletOld->getFileName());
			if(!$advert->getImageMobile() && $imgMobileOld) $advert->setImageMobile($imgMobileOld->getFileName());

			$this->getDoctrine()->getManager()->flush();

			$this->addFlash('success', 'advert.edited');

			return $this->redirectToRoute('octopouce_advertising_admin_advert_show', ['advert' => $advert->getId()]);
		}

		return $this->render('@OctopouceAdvertising/Admin/Advert/edit.html.twig', [
			'advert' => $advert,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/{advert}/delete", name="octopouce_advertising_admin_advert_delete")
	 */
	public function delete(Advert $advert) : Response {
		$em = $this->getDoctrine()->getManager();
		$campaignId = $advert->getCampaign()->getId();
		$em->remove($advert);
		$em->flush();

		$this->addFlash('success', 'advert.deleted');

		return $this->redirectToRoute('octopouce_advertising_admin_campaign_show', ['campaign'=>$campaignId]);
	}

	/**
	 * @Route("/{advert}/{adzone}/unlink", name="octopouce_advertising_admin_advert_unlink")
	 */
	public function unlink(Advert $advert, Adzone $adzone) : Response {
		$em = $this->getDoctrine()->getManager();
		$advert->removeAdzone($adzone);
		$adzone->removeAdvert($advert);
		$em->flush();

		$this->addFlash('success', 'advert.unlink');

		return $this->redirectToRoute('octopouce_advertising_admin_campaign_show', ['campaign'=>$advert->getCampaign()->getId()]);
	}

	/**
	 * @Route("/{advert}/{adzone}/link", name="octopouce_advertising_admin_advert_link")
	 */
	public function link(Advert $advert, Adzone $adzone) : Response {
		$em = $this->getDoctrine()->getManager();
		$advert->addAdzone($adzone);
		$adzone->addAdvert($advert);
		$em->flush();

		$this->addFlash('success', 'advert.link');

		return $this->redirectToRoute('octopouce_advertising_admin_campaign_show', ['campaign'=>$advert->getCampaign()->getId()]);
	}
}