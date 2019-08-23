<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 08/06/2018
 */

namespace Octopouce\AdvertisingBundle\Twig;


use Doctrine\ORM\EntityManagerInterface;
use Octopouce\AdvertisingBundle\Entity\Advert;
use Octopouce\AdvertisingBundle\Entity\Adzone;
use Octopouce\AdvertisingBundle\Entity\Statistic\View;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AdvertExtension extends AbstractExtension {

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * @var RequestStack
	 */
	private $request;

	/**
	 * AdvertExtension constructor.
	 *
	 * @param EntityManagerInterface $em
	 * @param RequestStack $request
	 */
	public function __construct( EntityManagerInterface $em, RequestStack $request)
	{
		$this->em = $em;
		$this->request = $request;
	}


	public function getFunctions(): array
	{
		return [
			new TwigFunction('adzone', [$this, 'showAdzone'])
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFilters(): array
	{
		return [
			new TwigFilter('class', [$this, 'addClass']),
		];
	}

	/**
	 * @param $adzoneName
	 * @param bool $html
	 * @param array $attr
	 *
	 * @return array|string
	 */
	public function showAdzone($adzoneName, $html = false, $attr = [])
	{

		$route = $this->request->getCurrentRequest()->get('_route');
		if($route === 'homepage') $route = 'home_index';

		$adzone = $this->em->getRepository(Adzone::class)->findOneByPageByAdzone($route, $adzoneName);
		if(!$adzone){
			$res = ['adzone' => null, 'adverts' => []];
		}

		$adverts = $this->em->getRepository(Advert::class)->findByActive(true, null, null, $adzone);
		if($adverts){
			$res = ['adzone' => $adzone, 'adverts' => $adverts];
		}else{
			$res = ['adzone' => $adzone, 'adverts' => []];
		}

		if(!$html) {
			return $res;
		}

		if($res['adzone'] == null){
			return '';
		}

		$html = '';

		if(isset($attr['classLink'])) { $classLink = $attr['classLink']; } else { $classLink = ''; }
		if(isset($attr['classImg'])) { $classImg = $attr['classImg']; } else { $classImg = ''; }

		if(isset($attr['width'])) {
			$width = $attr['width'];
		} elseif($adzone->getWidth()) {
			$width = $adzone->getWidth();
		} else {
			$width = '';
		}

		if(isset($attr['height'])) {
			$height = $attr['height'];
		} elseif($adzone->getHeight()) {
			$height = $adzone->getHeight();
		} else {
			$height = '';
		}

		if(count($adverts) > 0){
			foreach ($adverts as $advert){
				$html .= '<div class="col advertisingImg">
                            <p class="noMargin">
                            <a href="'.$advert->getLink().'" target="_blank" class="advocto adzone'.$adzone->getId().' advert'.$advert->getId().' '.$classLink.'">
				             <span class="desktopImg"><img src="/'.$advert->getImageDesktop()->getPathname().'" alt="'.$advert->getName().'" class="'.$classImg.'" width="'.$width.'" height="'.$height.'"></span>
				             <span class="tabletImg d-none d-md-block scrollAnimElement" delay="0.2" distance="10" duration="1" anim="fadeInUp"><img src="/'.$advert->getImageTablet()->getPathname().'" alt="'.$advert->getName().'" class="'.$classImg.'" width="'.$width.'" height="'.$height.'"></span>
                             <span class="mobileImg d-block d-md-none scrollAnimElement" delay="0.2" distance="10" duration="1" anim="fadeInUp"><img src="/'.$advert->getImageMobile()->getPathname().'" alt="'.$advert->getName().'" class="'.$classImg.'" width="'.$width.'" height="'.$height.'"></span>
				         </a></p></div>';
			}
		}else {
			$html .= '<span class="advocto adzone'.$adzone->getId().'"></span>';
		}

		return $html;

	}
}