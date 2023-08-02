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

    private function randomizer()
    {

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
            'Edgar Poe',
            'Frank Sinatra',
            'Grace Kelly',
            'Harry Potter',
            'Iris West',
            'Jack Sparrow',
            'Kathy Bates',
            'Liam Neeson',
            'Mary Poppins',
            'Ned Stark',
            'Oprah Winfrey',
            'Peter Pan',
            'Quentin Tarantino',
            'Ricky Martin',
            'Sarah Connor',
            'Tom Hanks',
            'Ursula Le Guin',
            'Vincent Vega',
            'Wendy Darling',
            'Xena Warrior Princess',
            'Yoda',
            'Zorro'
        );


        for($i = 1; $i < count($names) ; $i++){
            $user = (new Collaborateur())
                ->setPrenomNom($names[$i])
                ->setNiveauCompetence(rand(1,3))
                ->setPrimeEmbauche(0);

            // Check if the insertion was successful
            if ($user->save()) {
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
