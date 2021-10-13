<?php

namespace App\Form;

use App\Entity\WorkExperience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('employer')
            ->add('unit')
            ->add('startDate')
            ->add('endDate')
            ->add('isCurrent')
            ->add('summary')
            ->add('duties')
            ->add('interests')
            ->add('skillsUsed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WorkExperience::class,
        ]);
    }
}
