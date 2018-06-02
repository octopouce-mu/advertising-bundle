<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 22/03/2018
 */

namespace Octopouce\AdvertisingBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SwitchType extends AbstractType {

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParent()
	{
		return CheckboxType::class;
	}
}