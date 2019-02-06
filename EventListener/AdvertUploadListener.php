<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 06/06/2018
 */

namespace Octopouce\AdvertisingBundle\EventListener;

use Octopouce\AdvertisingBundle\Entity\Advert;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\LifecycleEventArgs;

class AdvertUploadListener {

	public function postLoad(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();

		if (!$entity instanceof Advert) {
			return;
		}

		$imageDesktop = $entity->getImageDesktop();
		if ($imageDesktop && file_exists($imageDesktop)) {
			$entity->setImageDesktop(new File($imageDesktop));
		} else{
			$entity->setImageDesktop(null);
		}

		$imageTablet = $entity->getImageTablet();
		if ($imageTablet && file_exists($imageTablet)) {
			$entity->setImageTablet(new File($imageTablet));
		} else{
			$entity->setImageTablet(null);
		}

		$imageMobile = $entity->getImageMobile();
		if ($imageMobile && file_exists($imageMobile)) {
			$entity->setImageMobile(new File($imageMobile));
		} else{
			$entity->setImageMobile(null);
		}
	}
}