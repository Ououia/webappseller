<?php
declare(strict_types=1);

namespace Phalcon\modules\frontend\controllers;



use Phalcon\Models\Collaborateur;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {

    }

    public function startGame()
    {
        shell_exec(" php run main add");
    }

}
