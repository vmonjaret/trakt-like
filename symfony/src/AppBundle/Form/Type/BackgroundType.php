<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BackgroundType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return ChoiceType::class;
    }

    public function configureOptions( OptionsResolver $resolver )
    {
        $resolver->setDefaults([
            'choices' => [
                'YlGnBu'   => 'YlGnBu',
                'YlOrRd'   => 'YlOrRd',
                'GnBu'     => 'GnBu',
                'YlOrBr'   => 'YlOrBr',
                'Purples'  => 'Purples',
                'Blues'    => 'Blues',
                'Oranges'  => 'Oranges',
                'Reds'     => 'Reds',
                'PuRd'     => 'PuRd',
            ],
            'expanded' => true,
            'multiple' => false,
            'required' => false
        ]);
    }


}