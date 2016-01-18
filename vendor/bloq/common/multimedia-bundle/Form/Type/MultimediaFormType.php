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
            ->add('type', 'choice', array(
                'required' => true,
                'choices' => array(
                    'image' => 'Imagen',
                    'video' => 'Video',
                    'audio' => 'Audio'
                ),
                'multiple' => false,
            ))
            ->add('position', 'choice', array(
                'required' => false,
                'placeholder' => 'Elija una posición',
                'choices' => array(
                    '1' => 'Párrafo 1',
                    '2' => 'Párrafo 2',
                    '3' => 'Párrafo 3',
                    '4' => 'Párrafo 4',
                    '5' => 'Párrafo 5',
                    '6' => 'Párrafo 6',
                    '7' => 'Párrafo 7',
                    '8' => 'Párrafo 8',
                    '9' => 'Párrafo 9',
                    '10' => 'Párrafo 10',
                    '11' => 'Párrafo 11',
                    '12' => 'Párrafo 12',
                    '13' => 'Párrafo 13',
                    '14' => 'Párrafo 14',
                    '15' => 'Párrafo 15',
                    '16' => 'Párrafo 16',
                    '17' => 'Párrafo 17',
                    '18' => 'Párrafo 18',
                    '19' => 'Párrafo 19',
                    '20' => 'Párrafo 20',
                    'primary' => 'Principal'
                ),
                'multiple' => false,
            ))
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
