<?php
declare(strict_types=1);

namespace Phalcon\modules\frontend\models;

use Phalcon\Modules\Frontend\Controllers\ControllerBase;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
      $param = "test";

        $this->view->param = $param;
    }

}

