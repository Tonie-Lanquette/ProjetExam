<?php

namespace App\Form;

use App\Entity\Build;
use App\Entity\Champion;
use App\Entity\Item;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('champion', EntityType::class, [
                'class' => Champion::class,
                'choice_label' => 'name',
            ])
            ->add('visibility')
            ->add('slots', CollectionType::class, [
            'entry_type' => SlotType::class, 
            'entry_options' => array('label' => false),
            'allow_add' => true, 
            'allow_delete' => true, 
            // 'by_reference' => false, // Nécessaire pour les relations OneToMany
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
