<?php

namespace App\Form;

use App\Entity\Build;
use App\Entity\Item;
use App\Entity\Slot;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
            ->add('build', EntityType::class, [
                'class' => Build::class,
                'choice_label' => 'id',
            ])
            ->add('item', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Slot::class,
        ]);
    }
}
