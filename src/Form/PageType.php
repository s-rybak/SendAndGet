<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/14/18
 * Time: 8:59 PM
 */

namespace App\Form;

use App\Entity\PageTranslation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('title')
			->add('excerpt')
			->add('content')
			->add('save', SubmitType::class);

	}


	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => PageTranslation::class,
			'allow_extra_fields' => true,
		));
	}

}