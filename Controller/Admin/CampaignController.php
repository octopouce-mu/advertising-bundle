<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 02/06/2018
 */

namespace Octopouce\AdvertisingBundle\Controller\Admin;

use Octopouce\AdvertisingBundle\Entity\Campaign;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/campaign")
 */
class CampaignController extends Controller
{
	/**
	 * @Route("/", name="octopouce_advertising_admin_campaign_index")
	 */
	public function index() : Response {
		$campaignsEnable = $this->getDoctrine()->getRepository(Campaign::class)->findByEnable(true, ['c.endDate' => 'DESC']);
		$campaignsDisable = $this->getDoctrine()->getRepository(Campaign::class)->findByEnable(false, ['c.endDate' => 'DESC']);

		return $this->render('@OctopouceAdvertising/Admin/Campaign/index.html.twig', [
			'campaignsEnable' => $campaignsEnable,
			'campaignsDisable' => $campaignsDisable
		]);
	}

	/**
	 * @Route("/{campaign}", name="octopouce_advertising_admin_campaign_show")
	 */
	public function show(Campaign $campaign) : Response {
		return $this->render('@OctopouceAdvertising/Admin/Campaign/show.html.twig', [
			'campaign' => $campaign
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

			return $this->redirectToRoute('octopouce_advertising_admin_campaign_index');
		}

		return $this->render('@OctopouceAdvertising/Admin/Campaign/create.html.twig', [
			'campaign' => $campaign
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
			'campaign' => $campaign
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