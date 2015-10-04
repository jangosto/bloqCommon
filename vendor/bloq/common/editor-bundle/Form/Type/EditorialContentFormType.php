<?php

namespace Bloq\Common\EditorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Bloq\Common\EditorBundle\Form\Type\EditorialContentFormType;

class EditorialContentFormType extends AbstractType
{
	private $class;

	/**
	 * @param string $class The Article class name
	 */
	public function __construct($class)
	{
		$this->class = $class;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('pretitle', null, array(
				'label' => 'form.pretitle',
				'required' => false
			))
			->add('title', null, array(
				'label' => 'form.title',
				'required' => true
			))
			->add('subtitle', null, array(
				'label' => 'form.subtitle',
				'required' => false
			))
			->add('text', null, array(
				'label' => 'form.text',
				'required' => false
			));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'edition',
        ));
    }

    public function getName()
	{
		return 'editor_editorial_content_edition';
	}
}