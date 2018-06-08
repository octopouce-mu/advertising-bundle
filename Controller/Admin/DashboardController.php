<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 30/05/2018
 */

namespace Octopouce\AdvertisingBundle\Controller\Admin;

use Octopouce\AdvertisingBundle\Entity\Advert;
use Octopouce\AdvertisingBundle\Entity\Adzone;
use Octopouce\AdvertisingBundle\Entity\Campaign;
use Octopouce\AdvertisingBundle\Utils\Statistics\CampaignStatistics;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends Controller
{
	/**
	 * @Route("/", name="octopouce_advertising_admin_dashboard_index")
	 */
	public function index(CampaignStatistics $campaignStatistics): Response
	{
		$em = $this->getDoctrine()->getManager();
		$adzones = $em->getRepository(Adzone::class)->findAll();
		uasort($adzones, function($a, $b){
			if ($a->getTotalViews() == $b->getTotalViews()) return 0;
			return ($a->getTotalViews() > $b->getTotalViews()) ? -1 : 1;
		});

		$adverts = $em->getRepository(Advert::class)->findByActive(true, ['c.startDate'=>'ASC'], 6);

		$stats = $campaignStatistics->getToday();

		return $this->render('@OctopouceAdvertising/Admin/Dashboard/index.html.twig', [
			'adzones' => $adzones,
			'adverts' => $adverts,
			'stats'   => $stats
		]);
	}
}