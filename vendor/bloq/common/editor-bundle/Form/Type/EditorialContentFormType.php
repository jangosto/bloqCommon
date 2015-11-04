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
                'allow_add' => false,
                'allow_delete' => false,
                'prototype' => false,
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
            ->add('sectionId', 'choice', array(
                'required' => true,
                'choices' => $this->getCategories(true),
                'multiple' => false
            ))
            ->add('categoryIds', 'choice', array(
                'required' => false,
                'choices' => $this->getCategories(),
                'expanded' => true,
                'multiple' => true,
                'empty_value' => 'Selecciona categorias',
                'empty_data' => false
            ))
            ->add('useCategoryAsPretitle', 'checkbox', array(
                'label' => 'Usar categoría como antetítulo',
                'required' => false
            ))
/*            ->add('tags', 'entity', array(
                'class' => 'Bloq\Common\EditorBundle\Entity\Tag',
                'required' => false,
                'property' => 'name',
                'multiple' => true
            ))
*/
            ->add('save', 'submit', array())
            ->add('publish', 'submit', array());
    }


    private function getCategories($withLevelator = false)
    {
        $categoriesArray = array();
        $this->getElementsArrayWithHierarchy($this->categoryManager->getAllWithHierarchy(true), $categoriesArray, 0, $withLevelator);
        
        return $categoriesArray;
    }

    private function getElementsArrayWithHierarchy($elements, &$elementsArray, $level = 0, $withLevelator = false)
    {
        $i = $level;
        $levelator = "";
        if ($withLevelator) {
            while ($i > 0) {
                $levelator .= "- ";
                $i--;
            }
        }

        foreach ($elements as $element) {
            $elementsArray[$element->getId()] = $levelator.$element->getName();
            if ($element->getChildren() !== null && count($element->getChildren()) > 0) {
                $this->getElementsArrayWithHierarchy($element->getChildren(), $elementsArray, $level+2, $withLevelator);
            }
        }
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
