<?php

namespace App\Form;

use App\Entity\Champion;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('username')
            ->add('gdpr', null, [
                'widget' => 'single_text',
            ])
            ->add('updated', null, [
                'widget' => 'single_text',
            ])
            ->add('created', null, [
                'widget' => 'single_text',
            ])
            ->add('favorite', EntityType::class, [
                'class' => Champion::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
