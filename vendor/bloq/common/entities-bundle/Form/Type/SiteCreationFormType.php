<?php

namespace Bloq\Common\EntitiesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SiteCreationFormType extends AbstractType
{
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
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
                'required' => false
            ))
            ->add('domain', null, array(
                'label' => 'form.domain',
                'required' => true
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'creation',
        ));
    }

    public function getName()
    {
        return 'admin_site_creation';
    }
}
