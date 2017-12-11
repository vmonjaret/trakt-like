<?php

namespace AppBundle\Twig\Extension;

use AppBundle\Entity\User;
use Symfony\Bridge\Twig\Extension\AssetExtension;
use Vich\UploaderBundle\Twig\Extension\UploaderExtension;

class AppExtension extends \Twig_Extension
{
    private $asset;
    private $vichAsset;

    /**
     * AppExtension constructor.
     * @param $asset
     * @param $vichAsset
     */
    public function __construct( AssetExtension $asset, UploaderExtension $vichAsset )
    {
        $this->asset = $asset;
        $this->vichAsset = $vichAsset;
    }


    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('getUserAvatar', [$this, 'getUserAvatar'])
        ];
    }

    public function getUserAvatar( User $user )
    {
        if ( $user->getAvatar() == null ) {
            return $this->asset->getAssetUrl('images/avatar_default.jpg');
        } else {
            return $this->vichAsset->asset($user, 'avatarFile');
        }
    }
}