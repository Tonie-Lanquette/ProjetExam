<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Build;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('build', EntityType::class, [
                'class' => Build::class,
                'choice_label' => 'title',
            ])
            ->add('title')
            ->add('introduction')
            ->add('starter_explication')
            ->add('core_explication')
            ->add('optional_explication')
            ->add('conclusion');
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
