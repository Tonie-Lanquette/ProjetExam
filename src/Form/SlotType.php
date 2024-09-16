<?php

namespace App\Form;

use App\Entity\Build;
use App\Entity\Item;
use App\Entity\Slot;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category')
            ->add('build', EntityType::class, [
                'class' => Build::class,
                'choice_label' => 'id',
            ])
            ->add('item', EntityType::class, [
                'class' => Item::class,
                'expanded' => true,
                'choice_label' => 'name',
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
