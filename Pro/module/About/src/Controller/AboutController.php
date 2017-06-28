<?php

namespace About\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AboutController extends AbstractActionController
{
    public function historyAction()
    {
        return new ViewModel();
    }
    public function howtoAction()
    {
        return new ViewModel();
    }
}
