<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 30/05/2018
 */

namespace Octopouce\AdvertisingBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{
	/**
	 * @Route("/", name="octo_adv_admin_dashboard_index")
	 */
	public function index(): Response
	{
		return $this->render('OctopouceAdvertisingBundle:Dashboard:index.html.twig');
	}
}