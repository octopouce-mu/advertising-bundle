<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 02/06/2018
 */

namespace Octopouce\AdvertisingBundle\Controller\Admin;

use Octopouce\AdvertisingBundle\Entity\Adzone;
use Octopouce\AdvertisingBundle\Entity\Campaign;
use Octopouce\AdvertisingBundle\Entity\Page;
use Octopouce\AdvertisingBundle\Form\CampaignType;
use Octopouce\AdvertisingBundle\Utils\Statistics\AdvertStatistics;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/campaign")
 * @IsGranted("ROLE_ADVERT")
 */
class CampaignController extends Controller
{
	/**
	 * @Route("/", name="octopouce_advertising_admin_campaign_index")
	 */
	public function index() : Response {
		$campaignsActive = $this->getDoctrine()->getRepository(Campaign::class)->findByActive(['c.endDate' => 'DESC']);
		$campaignsPassed = $this->getDoctrine()->getRepository(Campaign::class)->findByPassed(['c.endDate' => 'DESC']);
		$campaignsFuture = $this->getDoctrine()->getRepository(Campaign::class)->findByFuture(['c.startDate' => 'ASC']);

		return $this->render('@OctopouceAdvertising/Admin/Campaign/index.html.twig', [
			'campaignsActive' => $campaignsActive,
			'campaignsPassed' => $campaignsPassed,
			'campaignsFuture' => $campaignsFuture
		]);
	}

	/**
	 * @Route("/{campaign}/show", name="octopouce_advertising_admin_campaign_show")
	 */
	public function show(Campaign $campaign, AdvertStatistics $advertStatistics, Request $request) : Response {
		$em = $this->getDoctrine()->getManager();

		if($campaign->getAdverts()->count() > 0){
			foreach ($campaign->getAdverts() as $advert){
				$advertStatistics->addAdvert($advert);
			}

			$start = $request->get('start');
			$end = $request->get('end');

			if(!$start || !$end){
				$start = $campaign->getStartDate();
				$end = $campaign->getEndDate();
			}else {
				$start = new \DateTime($start);
				$end = new \DateTime($end);
				$end->modify('+1 day');
			}

			$stats = $advertStatistics->byDate($start, $end);
		}



		$pages = $em->getRepository(Page::class)->findAll();
		$adzones = $em->getRepository(Adzone::class)->findByNotPage();

		return $this->render('@OctopouceAdvertising/Admin/Campaign/show.html.twig', [
			'campaign' => $campaign,
			'pages'    => $pages,
			'adzones' => $adzones,
			'stats' => isset($stats) ? $stats : null
		]);
	}

	/**
	 * @Route("/create", name="octopouce_advertising_admin_campaign_create")
	 */
	public function create(Request $request) : Response {
		$campaign = new Campaign();

		$form = $this->createForm(CampaignType::class, $campaign);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($campaign);
			$em->flush();

			$this->addFlash('success', 'campaign.created');

			return $this->redirectToRoute('octopouce_advertising_admin_campaign_show', ['campaign' => $campaign->getId()]);
		}

		return $this->render('@OctopouceAdvertising/Admin/Campaign/create.html.twig', [
			'campaign' => $campaign,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/{campaign}/edit", name="octopouce_advertising_admin_campaign_edit")
	 */
	public function edit(Campaign $campaign, Request $request) : Response {
		$form = $this->createForm(CampaignType::class, $campaign);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			$this->addFlash('success', 'campaign.edited');

			return $this->redirectToRoute('octopouce_advertising_admin_campaign_index');
		}

		return $this->render('@OctopouceAdvertising/Admin/Campaign/edit.html.twig', [
			'campaign' => $campaign,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/{campaign}/delete", name="octopouce_advertising_admin_campaign_delete")
	 */
	public function delete(Campaign $campaign, Request $request) : Response {
		$em = $this->getDoctrine()->getManager();
		$em->remove($campaign);
		$em->flush();

		$this->addFlash('success', 'campaign.deleted');

		return $this->redirectToRoute('octopouce_advertising_admin_campaign_index');
	}
}