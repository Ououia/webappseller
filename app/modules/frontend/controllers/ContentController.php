<?php
declare(strict_types=1);

namespace Phalcon\modules\frontend\controllers;


use Phalcon\Models\Collaborateur;
use Phalcon\Models\Developpeur;
use Phalcon\Mvc\Controller;

class ContentController extends Controller
{
    public function indexAction()
    {
//        $myColab = Collaborateur::find( [
//            "prenom_nom = 'Jane Doe'",
//            "order" => "prime_embauche DESC"
//        ]);
        $devs = Developpeur::find();



        $this->view->test = $mapped;


    }


}
