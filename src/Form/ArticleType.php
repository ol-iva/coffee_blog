<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Title of your new article', 'required' => true])
//            ->add('slug', TextType::class, ['label' => 'Enter slug for your article with "-"'])
            ->add('content', TextType::class, ['label' => 'Content of new article'])
            ->add('imageFile', FileType::class, ['label' => 'Choose image for a new article', 'required' => false])
            ->add('publishedAt', null, ['label' => 'Article will be published at'])
            ->add('category', null, ['label' => 'Select category for new article']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}