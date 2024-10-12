<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Build;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $excludedBuildIds = $options['excluded_build_ids'];

        $builder
            ->add('build', EntityType::class, [
                'class' => Build::class,
                'choice_label' => 'title',
                'label' => 'Build  :',
                'query_builder' => function (EntityRepository $er) use ($user, $excludedBuildIds) {
                    $qb = $er->createQueryBuilder('b')
                        ->where('b.creator = :creator')
                        ->setParameter('creator', $user);

                    // Exclure les builds déjà associés à d'autres articles
                    if (!empty($excludedBuildIds)) {
                        $qb->andWhere('b.id NOT IN (:excluded_ids)')
                            ->setParameter('excluded_ids', $excludedBuildIds);
                    }

                    return $qb;
                },
            ])
            ->add('title', null, [
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
            'user' => null,
            'excluded_build_ids' => [],
        ]);
    }
}
