<?php

namespace Bloq\Common\EditorBundle\Form\Type\Components;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SummaryFormType extends AbstractType
{
    private $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
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
                ),
                'multiple' => false,
            ))
            ->add('text', 'textarea', array(
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
        return 'editor_summary_edition';
    }
}
