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
                'PuOr'     => 'PuOr',
                'GnBu'     => 'GnBu',
                'YlOrBr'   => 'YlOrBr',
                'PRGn'     => 'PRGn',
                'Purples'  => 'Purples',
                'Blues'    => 'Blues',
                'Oranges'  => 'Oranges',
                'Reds'     => 'Reds',
                'Spectral' => 'Spectral',
                'PuRd'     => 'PuRd',
            ],
            'expanded' => true,
            'multiple' => false,
            'required' => false
        ]);
    }


}