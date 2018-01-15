<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;

class ProfileController extends BaseController
{
    public function showAction()
    {
        $response = parent::showAction();

        dump('ok');

        die();
        return $response;
    }
}
