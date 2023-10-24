<?php

namespace App\Form;

use App\Entity\Finding;
use App\Entity\Mushroom;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FindingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'mushroom',
                EntityType::class, [
                    'class' => Mushroom::class,
                    'choice_label' => 'name',
                ]
            )
            ->add('quantity', NumberType::class, ['data' => 1])
            ->add('datetime', DateTimeType::class, ['data' => new \DateTime()])
            ->add('location', LocationType::class, [
                'required' => false,
                'label' => 'Localisation',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Finding::class,
        ]);
    }
}
