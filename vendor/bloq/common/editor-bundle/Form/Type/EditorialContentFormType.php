<?php

namespace Bloq\Common\EditorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Bloq\Common\MultimediaBundle\Form\Type\MultimediaFormType as MultimediaFormType;

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
            /*->add('section', null, array(
                'label' => 'form.section',
                'required' => false
            ))*/
			->add('pretitle', null, array(
				'label' => 'form.pretitle',
				'required' => false
			))
			->add('title', null, array(
				'label' => 'form.title',
				'required' => true
			))
            ->add('subtitles', 'collection', array(
                'type' => 'text',
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'options'  => array(
                    'required'  => false,
                    //'attr'      => array('class' => 'subtitle-box')
                )
            ))
            ->add('intro', 'textarea', array(
                'label' => 'form.intro',
                'required' => false
            ))
			->add('text', 'textarea', array(
				'label' => 'form.text',
                'required' => false
            ))
            ->add('multimedias', 'collection', array(
                'type' => new MultimediaFormType("Bloq\Common\MultimediaBundle\Entity\Multimedia"),
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'options'  => array(
                    'required'  => false,
                    //'attr'      => array('class' => 'subtitle-box')
                )
            ))
            ->add('summaries', 'collection', array(
                'type' => 'text',
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'options'  => array(
                    'required'  => false,
                    //'attr'      => array('class' => 'subtitle-box')
                )
            ))
            ->add('category', 'entity', array(
                'class' => 'Bloq\Common\EditorBundle\Entity\Category',
                'required' => false,
                'property' => 'name',
                'multiple' => false
            ))
            ->add('useCategoryAsPretitle', 'checkbox', array(
                'label' => 'Usar categoría como antetítulo',
                'required' => false
            ))
            ->add('tags', 'entity', array(
                'class' => 'Bloq\Common\EditorBundle\Entity\Tag',
                'required' => false,
                'property' => 'name',
                'multiple' => true
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
