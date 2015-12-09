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
    private $multimediaFormType;
    private $categoryManager;
    private $tagManager;
    private $assignedCategories;
    private $assignedTags;

	/**
	 * @param string $class The Article class name
	 */
	public function __construct($class, $multimediaFormType, $categoryManager, $tagManager)
	{
        $this->class = $class;
        $this->multimediaFormType = $multimediaFormType;
        $this->categoryManager = $categoryManager;
        $this->tagManager = $tagManager;
        $this->assignedCategories = array();
        $this->assignedTags = array();
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
            ->add('seoTitle', 'checkbox', array(
                'label' => 'Usar título SEO',
                'required' => false
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
                'type' => $this->multimediaFormType,
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
                'data' => $this->assignedCategories
            ))
            ->add('useCategoryAsPretitle', 'checkbox', array(
                'label' => 'Usar categoría como antetítulo',
                'required' => false
            ))
            ->add('tagIds', 'choice', array(
                'required' => false,
                'choices' => $this->getTags(),
                'expanded' => true,
                'multiple' => true,
                'data' => $this->assignedTags
            ))
            ->add('save', 'submit', array())
            ->add('publish', 'submit', array());
    }


    private function getCategories($withLevelator = false)
    {
        $categoriesArray = array();
        $this->getElementsArrayWithHierarchy($this->categoryManager->getAllWithHierarchy(true), $categoriesArray, 0, $withLevelator);
        
        return $categoriesArray;
    }

    private function getTags($withLevelator = false)
    {
        $tagsArray = array();
        $this->getElementsArrayWithHierarchy($this->tagManager->getAllWithHierarchy(true), $tagsArray, 0, $withLevelator);

        return $tagsArray;
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
    
    /**
     * Get assignedCategories.
     *
     * @return assignedCategories.
     */
    public function getAssignedCategories()
    {
        return $this->assignedCategories;
    }
    
    /**
     * Set assignedCategories.
     *
     * @param assignedCategories the value to set.
     */
    public function setAssignedCategories($assignedCategories)
    {
        $this->assignedCategories = $assignedCategories;
    }
    
    /**
     * Get assignedTags.
     *
     * @return assignedTags.
     */
    public function getAssignedTags()
    {
        return $this->assignedTags;
    }
    
    /**
     * Set assignedTags.
     *
     * @param assignedTags the value to set.
     */
    public function setAssignedTags($assignedTags)
    {
        $this->assignedTags = $assignedTags;
    }
}
