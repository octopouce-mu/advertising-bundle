<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 30/05/2018
 */

namespace Octopouce\AdvertisingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends Controller
{
	/**
	 * @Route("/adv", name="octopouce_advertising_index")
	 */
	public function index(): Response
	{
		return $this->render('OctopouceAdvertisingBundle:Dashboard:index.html.twig');
	}
}