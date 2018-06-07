<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 02/06/2018
 */

namespace Octopouce\AdvertisingBundle\Form;

use Octopouce\AdvertisingBundle\Entity\Advert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
//		var_dump($builder->getData()->getImageDesktop());die;

		$builder
			->add('name', TextType::class)
			->add('link', UrlType::class)

			->add('imageDesktop', FileType::class, [
				'required' => false
			])
			->add('imageTablet', FileType::class, [
				'required' => false
			])
			->add('imageMobile', FileType::class, [
				'required' => false
			])

			->add('submit', SubmitType::class, [
				'label' => 'save',
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Advert::class
		]);
	}
}