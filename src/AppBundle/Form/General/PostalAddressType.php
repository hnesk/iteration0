<?php

namespace AppBundle\Form\General;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\General\PostalAddress;

class PostalAddressType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('streetAddress')
            ->add('postalCode')
            ->add('locality')
            ->add('region')
            ->add('country','country')
            #->add('postOfficeBoxNumber')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PostalAddress::class
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'postaladdress';
    }
}
