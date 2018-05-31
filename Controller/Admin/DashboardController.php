<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 30/05/2018
 */

namespace Octopouce\AdvertisingBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
	/**
	 * @Route("/", name="octopouce_advertising_admin_dashboard_index")
	 */
	public function index(): Response
	{
		return $this->render('@OctopouceAdvertising/Dashboard/index.html.twig');
	}
}