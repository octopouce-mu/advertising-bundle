<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 06/06/2018
 */

namespace Octopouce\AdvertisingBundle\EventListener;

use Octopouce\AdvertisingBundle\Entity\Advert;
use Octopouce\AdvertisingBundle\Utils\FileUploader;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class AdvertUploadListener {

	private $uploader;

	public function __construct(FileUploader $uploader)
	{
		$this->uploader = $uploader;
	}

	public function postPersist(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();

		if (!$entity instanceof Advert) {
			return;
		}

		$this->uploadFile($entity);
		$entityManager = $args->getObjectManager();
		$entityManager->flush();
	}

	public function preUpdate(PreUpdateEventArgs $args)
	{
		$entity = $args->getEntity();

		$this->uploadFile($entity);
	}

	public function postLoad(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();

		if (!$entity instanceof Advert) {
			return;
		}

		$dir = $this->uploader->getTargetDirectory().'/'.$entity->getId();
		if ($entity->getImageDesktop() && file_exists($dir.'/'.$entity->getImageDesktop())) {
			$entity->setImageDesktop(new File($dir.'/'.$entity->getImageDesktop()));
		}else{
			$entity->setImageDesktop(null);
		}

		if ($entity->getImageTablet() && file_exists($dir.'/'.$entity->getImageTablet())) {
			$entity->setImageTablet(new File($dir.'/'.$entity->getImageTablet()));
		}else{
			$entity->setImageTablet(null);
		}

		if ($entity->getImageMobile() && file_exists($dir.'/'.$entity->getImageMobile())) {
			$entity->setImageMobile(new File($dir.'/'.$entity->getImageMobile()));
		}else{
			$entity->setImageMobile(null);
		}
	}

	private function uploadFile($entity)
	{
		// upload only works for Advert entities
		if (!$entity instanceof Advert) {
			return;
		}

		$fileDesktop = $entity->getImageDesktop();
		$fileTablet = $entity->getImageTablet();
		$fileMobile = $entity->getImageMobile();

		// only upload new files
		if ($fileDesktop instanceof UploadedFile) {
			$imgDesktopName = $this->uploader->upload($fileDesktop, $entity->getId());
			$entity->setImageDesktop($imgDesktopName);
		}elseif($fileDesktop instanceof File){
			$entity->setImageDesktop($fileDesktop->getFilename());
		}

		// only upload new files
		if ($fileTablet instanceof UploadedFile) {
			$imgTabletName = $this->uploader->upload($fileTablet, $entity->getId());
			$entity->setImageTablet($imgTabletName);
		}elseif($fileTablet instanceof File){
			$entity->setImageTablet($fileTablet->getFilename());
		}

		// only upload new files
		if ($fileMobile instanceof UploadedFile) {
			$imgMobileName = $this->uploader->upload($fileMobile, $entity->getId());
			$entity->setImageMobile($imgMobileName);
		}elseif($fileMobile instanceof File){
			$entity->setImageMobile($fileMobile->getFilename());
		}

	}
}