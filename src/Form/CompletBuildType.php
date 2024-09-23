<?php

namespace App\Form;

use App\Entity\Build;
use App\Entity\Champion;
use App\Entity\Item;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildSlotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Champs provenant de BuildType
        $builder
            ->add('title', null, [
                'label' => 'Build Name :',
            ])
            ->add('champion', EntityType::class, [
                'class' => Champion::class,
                'label' => 'For who ?',
            ]);

        // Champs provenant de SlotType
        $builder
            ->add('category', ChoiceType::class, [
                'choices'  => [
                    'Starter Items' => 'starter_items',
                    'Core Items'    => 'core_items',
                    'Optional Items' => 'optional_items',
                ],
                'multiple' => false,
                'expanded' => false,
                'label'    => 'Category',
            ])
            ->add('item', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'id',
                'multiple' => true,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Build::class,
        ]);
    }
}
