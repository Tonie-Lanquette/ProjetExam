<?php

namespace App\Form;

use App\Entity\Build;
use App\Entity\Champion;
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
            ->add('title', null,[
                'label' => 'Title :',
            ])
            ->add('champion', EntityType::class, [
                'class' => Champion::class,
                'choice_label' => 'name',
                'label' => 'Champion :',
            ])
            ->add('slots', CollectionType::class, [
                'entry_type' => SlotType::class, 
                'entry_options' => ['label' => false],
                'allow_add' => true, 
                'allow_delete' => true, 
                'by_reference' => false, 
                'attr' => ['data-controller' => 'form-collection']
             ])
            ->add('visibility', null,[
                'label' => 'Keep it private',
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
