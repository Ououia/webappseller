<?php
declare(strict_types=1);

namespace Phalcon\Modules\Cli\Tasks;

use Phalcon\Models\Chefdeprojet;
use Phalcon\Models\Collaborateur;

class MainTask extends \Phalcon\Cli\Task
{
    public function mainAction()
    {
        echo "Congratulations! You are now flying with Phalcon CLI!";
    }


}
