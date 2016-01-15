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
            ->add('metaTitle', null, array(
                'label' => 'form.metaTitle',
                'required' => true
            ))
            ->add('description', 'textarea', array(
                'label' => 'form.description',
                'required' => true
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
        $tagsArray = array();
        $this->getElementsArrayWithHierarchy($this->tagManager->getAllWithHierarchy(), $tagsArray);

        return $tagsArray;
    }

    private function getElementsArrayWithHierarchy($elements, &$elementsArray, $level = 0)
    {
        $i = $level;
        $levelator = "";
        while ($i > 0) {
            $levelator .= "-";
            $i--;
        }

        foreach ($elements as $element) {
            $elementsArray[$element->getId()] = $levelator." ".$element->getName();
            if ($element->getChildren() !== null && count($element->getChildren()) > 0) {
                $this->getElementsArrayWithHierarchy($element->getChildren(), $elementsArray, $level+2);
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
		return 'editor_tag_edition';
	}
}
