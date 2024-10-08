<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

            $builder
            ->add('username', TextType::class, [
                'label' => 'Username :',
             ])
            ->add( 'email', TextType::class, [
            'label' => 'Email :',
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false
            ])
            ->add('confirmationPassword', PasswordType::class, [
                'mapped' => false,
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
