<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 02/06/2018
 */

namespace Octopouce\AdvertisingBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Octopouce\AdvertisingBundle\Entity\Adzone;
use Octopouce\AdvertisingBundle\Form\AdzoneType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adzone")
 */
class AdzoneController extends Controller
{
	/**
	 * @Route("/", name="octopouce_advertising_admin_adzone_index")
	 */
	public function index() : Response {
		$adzones = $this->getDoctrine()->getRepository(Adzone::class)->findBy([], ['name'=>'ASC']);

		return $this->render('@OctopouceAdvertising/Admin/Adzone/index.html.twig', [
			'adzones' => $adzones
		]);
	}

	/**
	 * @Route("/create", name="octopouce_advertising_admin_adzone_create")
	 */
	public function create(Request $request) : Response {
		$adzone = new Adzone();

		$form = $this->createForm(AdzoneType::class, $adzone);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($adzone);
			$em->flush();

			$this->addFlash('success', 'adzone.created');

			return $this->redirectToRoute('octopouce_advertising_admin_adzone_index');
		}

		return $this->render('@OctopouceAdvertising/Admin/Adzone/create.html.twig', [
			'adzone' => $adzone,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/{adzone}/edit", name="octopouce_advertising_admin_adzone_edit")
	 */
	public function edit(Adzone $adzone, Request $request) : Response {
		$form = $this->createForm(AdzoneType::class, $adzone);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			$this->addFlash('success', 'adzone.edited');

			return $this->redirectToRoute('octopouce_advertising_admin_adzone_index');
		}

		return $this->render('@OctopouceAdvertising/Admin/Adzone/edit.html.twig', [
			'adzone' => $adzone,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/{adzone}/delete", name="octopouce_advertising_admin_adzone_delete")
	 */
	public function delete(Adzone $adzone, Request $request) : Response {
		$em = $this->getDoctrine()->getManager();
		$em->remove($adzone);
		$em->flush();

		$this->addFlash('success', 'adzone.deleted');

		return $this->redirectToRoute('octopouce_advertising_admin_adzone_index');
	}
}