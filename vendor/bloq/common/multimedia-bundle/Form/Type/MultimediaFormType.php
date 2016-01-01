<?php

namespace Bloq\Common\MultimediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MultimediaFormType extends AbstractType
{
    private $class;
    private $imagesRootDirPath;
    private $imagesRootDirUrl;

    public function __construct($class, $imagesRootDirPath, $imagesRootDirUrl)
    {
        $this->class = $class;
        $this->imagesRootDirPath = $imagesRootDirPath;
        $this->imagesRootDirUrl = $imagesRootDirUrl;
    }

    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $multimedia = new $this->class();
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
            ->add('description', 'textarea', array(
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
            ->add('rectangle', 'text', array(
                'property_path' => 'crops[rectangle]'
            ))
            ->add('square', 'text', array(
                'property_path' => 'crops[square]'
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
