<?php

namespace Bloq\Common\EditorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Bloq\Common\MultimediaBundle\Form\Type\MultimediaFormType as MultimediaFormType;

class CategoryFormType extends AbstractType
{
    private $class;
    private $categoryManager;

	/**
	 * @param string $class The Article class name
	 */
	public function __construct($class, $categoryManager)
	{
        $this->class = $class;
        $this->categoryManager = $categoryManager;
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
                'choices' => $this->getCategories(),
                'multiple' => false
            ))
            ->add('save', 'submit', array());
    }

    private function getCategories()
    {
        $categories = $this->categoryManager->getAll();

        $categoriesArray = array();
        foreach ($categories as $category) {
            $categoriesArray[$category->getId()] = $category->getName();
        }

        return $categoriesArray;
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
		return 'editor_category_edition';
	}
}
