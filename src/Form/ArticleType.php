<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Build;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
                'label' => 'Target  :'
            ])
            ->add('title', null,[
                'label' => 'Title :',
            ])
            ->add('introduction', null, [
                'label' => 'Introduction :',
            ])
            ->add('starter_explication', null, [
            'label' => 'About starter items :',
            ])
            ->add('core_explication', null, [
            'label' => 'About core items :',
            ])
            ->add('optional_explication', null, [
            'label' => 'About optional items :',
            ])
            ->add('conclusion', null, [
            'label' => 'Conclusion :',
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
