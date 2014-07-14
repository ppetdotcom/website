<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PagesController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function aboutMicrochippingAction()
    {
        return new ViewModel();
    }

    public function contactUsAction()
    {
        return new ViewModel();
    }

    public function reportLostFoundAction()
    {
        return new ViewModel();
    }

    public function insuranceAction()
    {
        return new ViewModel();
    }

    public function registerMicroChipAction()
    {
        return new ViewModel();
    }


}

