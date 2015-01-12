<?php

namespace AppBundle\Form\Credit;

use AppBundle\Entity\Credit\Lender;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\Credit\Agreement;

class AgreementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lender', 'entity', ['class' => Lender::class])
            ->add('amount', 'money', ['currency' => 'EUR'])
            ->add('interest', 'percent')
            ->add('periodOfNotice', 'integer')
            ->add('periodStart', 'date')
            ->add('periodEnd', 'date')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Agreement::class,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'credit_agreement';
    }
}
