<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 06/06/2018
 */

namespace Octopouce\AdvertisingBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Octopouce\AdvertisingBundle\Entity\Page;
use Octopouce\AdvertisingBundle\Form\PageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/page")
 * @IsGranted("ROLE_ADVERT")
 */
class PageController extends Controller
{
	/**
	 * @Route("/", name="octopouce_advertising_admin_page_index")
	 */
	public function index() : Response {
		$pages = $this->getDoctrine()->getRepository(Page::class)->findBy([], ['name'=>'ASC']);

		return $this->render('@OctopouceAdvertising/Admin/Page/index.html.twig', [
			'pages' => $pages
		]);
	}

	/**
	 * @Route("/create", name="octopouce_advertising_admin_page_create")
	 */
	public function create(Request $request) : Response {
		$page = new Page();

		$form = $this->createForm(PageType::class, $page);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($page);
			$em->flush();

			$this->addFlash('success', 'page.created');

			return $this->redirectToRoute('octopouce_advertising_admin_page_index');
		}

		return $this->render('@OctopouceAdvertising/Admin/Page/create.html.twig', [
			'page' => $page,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/{page}/edit", name="octopouce_advertising_admin_page_edit")
	 */
	public function edit(Page $page, Request $request) : Response {
		$form = $this->createForm(PageType::class, $page);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			$this->addFlash('success', 'page.edited');

			return $this->redirectToRoute('octopouce_advertising_admin_page_index');
		}

		return $this->render('@OctopouceAdvertising/Admin/Page/edit.html.twig', [
			'page' => $page,
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route("/{page}/delete", name="octopouce_advertising_admin_page_delete")
	 */
	public function delete(Page $page, Request $request) : Response {
		$em = $this->getDoctrine()->getManager();
		$em->remove($page);
		$em->flush();

		$this->addFlash('success', 'page.deleted');

		return $this->redirectToRoute('octopouce_advertising_admin_page_index');
	}
}