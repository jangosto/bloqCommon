<?php

namespace Bloq\Common\EditorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Bloq\Common\MultimediaBundle\Form\Type\MultimediaFormType as MultimediaFormType;

class TagFormType extends AbstractType
{
    private $class;
    private $tagManager;

	/**
	 * @param string $class The Article class name
	 */
	public function __construct($class, $tagManager)
	{
        $this->class = $class;
        $this->tagManager = $tagManager;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
        $builder
            ->add('name', null, array(
                'label' => 'form.name',
                'required' => true
            ))
            ->add('slug', null, array(
                'label' => 'form.slug',
                'required' => true
            ))
            ->add('description', 'textarea', array(
                'label' => 'form.description',
                'required' => false
            ))
            ->add('parentId', 'choice', array(
                'required' => false,
                'choices' => $this->getTags(),
                'multiple' => false
            ))
            ->add('save', 'submit', array());
	}

    private function getTags()
    {
        $tags = $this->tagManager->getAll();

        $tagsArray = array();
        foreach ($tags as $tag) {
            $tagsArray[$tag->getId()] = $tag->getName();
        }

        return $tagsArray;
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
		return 'editor_tag_edition';
	}
}
