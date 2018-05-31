<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 30/05/2018
 */

namespace Octopouce\AdvertisingBundle\Controller\Admin;

use Octopouce\AdvertisingBundle\Entity\Adzone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends Controller
{
	/**
	 * @Route("/", name="octopouce_advertising_admin_dashboard_index")
	 */
	public function index(): Response
	{
		$em = $this->getDoctrine()->getManager();
		$adzones = $em->getRepository(Adzone::class)->findAll();
		var_dump($adzones[0]);die;
		return $this->render('@OctopouceAdvertising/Admin/Dashboard/index.html.twig');
	}
}