<?php
declare(strict_types=1);

namespace Phalcon\modules\frontend\controllers;



use Phalcon\Models\Collaborateur;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $myApp = Collaborateur::findFirst(1);

        $test = $myApp->getPrenomNom();

        $this->view->test = $test;
    }
}
