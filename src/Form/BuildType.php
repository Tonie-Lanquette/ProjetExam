<?php

namespace App\Form;

use App\Entity\Build;
use App\Entity\Champion;
use App\Entity\Item;
use App\Entity\Slot;
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
            ->add('champion', EntityType::class, [
                'class' => Champion::class,
                'choice_label' => 'name',
            ])

            // ->add('category', EntityType::class,[
            //     'class' => Slot::class,
                
            // ])

            // ->add('item', EntityType::class, [
            //     'class' => Item::class,
            //     'expanded' => true,
            //     'choice_label' => 'name',
            //     'multiple' => true,
            // ])
            //from Slotype
            ->add('visibility')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Build::class,
        ]);
    }
}
