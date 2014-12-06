<?php

namespace AppBundle\Form\Credit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\Credit\Lender;

class LenderType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'personname')
            ->add('address', 'postaladdress')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Lender::class
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'credit_lender';
    }
}
