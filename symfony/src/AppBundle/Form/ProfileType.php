<?php

namespace AppBundle\Form;

use AppBundle\Form\Type\BackgroundType;
use FOS\UserBundle\Form\Type\ProfileFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfileType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder->add('avatarFile', VichImageType::class, [
            'label'         => 'Avatar',
            'download_link' => false,
            'required'      => false,
        ])->add('background', BackgroundType::class, [ 'label' => 'Fond de profile', ]);
    }

    public function getParent()
    {
        return ProfileFormType::class;
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
}