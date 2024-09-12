<?php

namespace App\Form;

use App\Entity\Build;
use App\Entity\Champion;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('visibility')
            ->add('created', null, [
                'widget' => 'single_text',
            ])
            ->add('updated', null, [
                'widget' => 'single_text',
            ])
            ->add('creator', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('champion', EntityType::class, [
                'class' => Champion::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Build::class,
        ]);
    }
}
