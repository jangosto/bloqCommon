<?php

namespace Bloq\Common\MultimediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MultimediaFormType extends AbstractType
{
    private $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add('file', 'file', array(
                'label' => 'form.file',
                'required' => false
            ))
            ->add('path', null, array(
                'label' => 'form.path',
                'required' => 'false'
            ))
            ->add('title', null, array(
                'label' => 'form.title',
                'required' => false
            ))
            ->add('description', null, array(
                'label' => 'form.description',
                'required' => false
            ))
            ->add('alt', null, array(
                'label' => 'form.alt',
                'required' => false
            ))
            ->add('author', null, array(
                'label' => 'form.author',
                'required' => false
            ))
            ->add('agency', null, array(
                'label' => 'form.agency',
                'required' => false
            ))
            ->add('htmlCode', 'textarea', array(
                'label' => 'form.htmlCode',
                'required' => false
            ))
            ->add('position', null, array(
                'label' => 'form.position',
                'required' => false
            ))
            ->add('type', null, array(
                'label' => 'form.type',
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
        return 'multimedia_multimedia_edition';
    }
}
