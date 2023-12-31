<?php
declare(strict_types=1);

namespace Phalcon\modules\frontend\controllers;



use Phalcon\Helper\Arr;
use Phalcon\Models\Chefdeprojet;
use Phalcon\Models\Collaborateur;
use Phalcon\Models\CompositionEquipe;
use Phalcon\Models\Developpeur;
use Phalcon\Models\Team;
use \Phalcon\Modules\Frontend\Controllers\ControllerBase;

class IndexController extends ControllerBase
{

    private function randomizer(): int
    {
        $rand = mt_rand(1, 10);
        if ($rand <= 6) {
            // 60% chance
            return 1;
        } elseif ($rand <= 9) {
            // 30% chance
            return 2;
        } else {
            // 10% chance
            return 3;
        }
    }

    public function indexAction()
    {
        $hideHeader = true;

        $this->view->hideHeader = $hideHeader;
    }

    public function startGameAction(): \Phalcon\Http\ResponseInterface
    {


        try {
            CompositionEquipe::find()->delete();
            Team::find()->delete();
            Developpeur::find()->delete();
            Chefdeprojet::find()->delete();
            Collaborateur::find()->delete();

        } catch (\Exception $e) {
            echo "Une erreur est survenu, veuillez reessayer";
        }

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

        /** créer les collaborateurs par rapport a liste de nom données */

        $prime = 0;

        for ($i = 1; $i < count($names); $i++) {
            switch ($randomizer = $this->randomizer()) {
                case 1:
                    $prime = rand(900, 1200);
                    break;
                case 2:
                    $prime = rand(1900, 2100);
                    break;
                case 3:
                    $prime = rand(2900, 3100);
                    break;
            }

            $user = (new Collaborateur())
                ->setPrenomNom($names[$i])
                ->setNiveauCompetence($randomizer)
                ->setPrimeEmbauche($prime);


            if (!$user->save()) {
                echo "Nous avons recontrer des erreurs : ";
                $messages = $user->getMessages();

                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br>";
                }
            }

        }

        /** Attribut un metier a chaque collaborateur , 70% des collaborateurs sont de dev le reste des chefs de projet */

        $totalDev = intval(Collaborateur::count() * 0.7); // 60% of people
        $count = 0;
        foreach (Collaborateur::find(['order' => 'RAND()']) as $collab) {
            if ($count <= $totalDev) {
                // make this collab a dev
                (new Developpeur())
                    ->setCollaborateurId($collab->getId())
                    ->setCompetence(rand(1, 3))
                    ->setIndiceProduction(rand(1, 3))
                    ->save();
            } else {
                // make this collab a manager
                (new Chefdeprojet())
                    ->setCollaborateurId($collab->getId())
                    ->setBoostProduction(rand(10, 30))
                    ->save();
            }
            $count++;

        }

        return $this->response->redirect($this->url->get("/dashboard"));
    }

}