<?php
/**
 * Created by PhpStorm.
 * User: sergej
 * Date: 11/14/18
 * Time: 8:59 PM
 */

namespace App\Form;

use App\Entity\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileFormType extends AbstractType{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name')
			->add('status')
			->add('save', SubmitType::class);

	}


	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => File::class,
			'allow_extra_fields' => true,
		));
	}

}