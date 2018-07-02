<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 02/06/2018
 */

namespace Octopouce\AdvertisingBundle\Form;

use Octopouce\AdvertisingBundle\Entity\Adzone;
use Octopouce\AdvertisingBundle\Entity\Page;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdzoneType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{

		$builder
			->add('name', TextType::class)

			->add('width', IntegerType::class, [
				'required' => false
			])
			->add('height', IntegerType::class, [
				'required' => false
			])

			->add('pages', EntityType::class,[
				'multiple' => true,
				'class' => Page::class,
				'required' => false,
				'attr' => ['placeholder' => 'Choose pages']
			])

			->add('submit', SubmitType::class, [
				'label' => 'save',
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Adzone::class
		]);
	}

	public function getBlockPrefix()
	{
		return "zone";
	}
}