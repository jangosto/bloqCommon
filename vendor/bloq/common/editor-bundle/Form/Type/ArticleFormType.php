<?php

namespace Bloq\Common\EditorBundle\Form\Type;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Bloq\Common\EditorBundle\Form\Type\EditorialContentFormType;

class ArticleFormType extends EditorialContentFormType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
	}

	public function getName()
	{
		return 'editor_article_edition';
	}
}