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
        $builder
/*            ->add('file', 'file', array(
                'label' => 'form.file',
                'required' => false
            ))*/
            ->add('image', 'comur_image', array(
                'uploadConfig' => array(
                    //'uploadRoute' => 'comur_api_upload',        //optional
                    'uploadUrl' => $this->imagesRootDirPath,       // required - see explanation below (you can also put just a dir path)
                    'webDir' => $this->imagesRootDirUrl,              // required - see explanation below (you can also put just a dir path)
                    //'fileExt' => '*.jpg;*.gif;*.png;*.jpeg',    //optional
                    //'libraryDir' => null,                       //optional
                    //'libraryRoute' => 'comur_api_image_library', //optional
                    //'showLibrary' => true,                      //optional
                    //'saveOriginal' => 'originalImage'           //optional
                ),
                'cropConfig' => array(
                    'minWidth' => 588,
                    'minHeight' => 300,
                    //'aspectRatio' => true,              //optional
                    //'cropRoute' => 'comur_api_crop',    //optional
                    //'forceResize' => false,             //optional
                    'thumbs' => array(                  //optional
                        array(
                            'maxWidth' => '100%',
                            'maxHeight' => 200,
                            'useAsFieldImage' => true  //optional
                        )
                    )
                )
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
