<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {
        return new ViewModel();
    }

    public function logoutAction()
    {
        return new ViewModel();
    }

    public function forgottenPasswordAction()
    {
        return new ViewModel();
    }

    public function changePasswordAction()
    {
        return new ViewModel();
    }

    public function changeOwnershipAction()
    {
        return new ViewModel();
    }

    public function editDetailsAction()
    {
        return new ViewModel();
    }

    public function reportLostStolenAction()
    {
        return new ViewModel();
    }


}

