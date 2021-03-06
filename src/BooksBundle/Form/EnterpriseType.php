<?php

namespace BooksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnterpriseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null,array('label' => 'Nombre','attr' => array('class'=>'form-control')))
            ->add('rut', null,array('label' => 'Nombre','attr' => array('class'=>'form-control')))
            ->add('address', null,array('label' => 'Nombre','attr' => array('class'=>'form-control')))
            ->add('order', null,array('label' => 'Nombre','attr' => array('class'=>'form-control')))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BooksBundle\Entity\Enterprise'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'booksbundle_enterprise';
    }


}
