<?php
declare(strict_types=1);

namespace Phalcon\Modules\Cli\Tasks;

use Phalcon\Models\Collaborateur;

class MainTask extends \Phalcon\Cli\Task
{
    public function mainAction()
    {
        echo "Congratulations! You are now flying with Phalcon CLI!";
    }

    public function addAction()
    {
        // Create a new user object


        $names = array(
            'John Smith',
            'Jane Doe',
            'Peter Parker',
            'Paul Allen',
            'Sue Storm',
            'Alice Johnson',
            'Bob Marley',
            'Charlie Brown',
            'Debbie Reynolds',
            'Edgar Poe'
        );

        for($i = 1; $i < count($names) ; $i++){
            $user = new Collaborateur();

            // Assign values to the user
            $user->setPrenomNom($names[$i]);
            $user->setNiveauCompetence(rand(1,3));
            $user->setPrimeEmbauche(rand(1000,10000));

            // Save the user to the database
            $success = $user->save();

            // Check if the insertion was successful
            if ($success) {
                echo "The user" . $i . "was created successfully!\n" ;
            } else {
                echo "Sorry, the following problems were generated: ";
                $messages = $user->getMessages();

                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br>";
                }
            }
        }

    }
}
