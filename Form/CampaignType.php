<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 02/06/2018
 */

namespace Octopouce\AdvertisingBundle\Form;

use Octopouce\AdvertisingBundle\Entity\Campaign;
use Octopouce\AdminBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampaignType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{

		$builder
			->add('name', TextType::class)
			->add('description', TextareaType::class)

			->add('startDate', DateTimePickerType::class, [
				'date_widget' => 'single_text',
				'time_widget' => 'single_text',
				'attr' => ['class' => 'datepicker']
			])
			->add('endDate', DateTimePickerType::class, [
				'date_widget' => 'single_text',
				'time_widget' => 'single_text',
				'attr' => ['class' => 'datepicker']
			])

			->add('submit', SubmitType::class, [
				'label' => 'save',
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Campaign::class
		]);
	}
}