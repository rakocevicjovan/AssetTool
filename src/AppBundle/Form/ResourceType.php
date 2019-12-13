<?php

namespace AppBundle\Form;

use AppBundle\Entity\ResType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResourceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('path')
        ->add('name')
        ->add('resType', EntityType::class, 
            [
                'class' => ResType::class, 
                'query_builder' => function(\AppBundle\Repository\ResTypeRepository $repository)
                { 
                    return $repository->createQueryBuilder('u')->orderBy('u.id', 'ASC');
                }
            ]
        )
        ->add('level');

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Resource'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_resource';
    }

}