<?php

namespace AppBundle\Form\General;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\General\PersonName;

class PersonNameType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'gender',
                'choice',
                [
                    'choices' => ['m' => 'Herr', 'f' => 'Frau']
                ]
            )
            ->add('firstName')
            ->add('lastName')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PersonName::class,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'personname';
    }
}
