<?php
declare(strict_types=1);

namespace Phalcon\modules\frontend\controllers;


use mysql_xdevapi\Exception;
use Phalcon\Models\Chefdeprojet;
use Phalcon\Models\Composant;
use Phalcon\Models\CompositionEquipe;
use Phalcon\Models\Developpeur;
use Phalcon\Models\Team;
use \Phalcon\Modules\Frontend\Controllers\ControllerBase;

class DashboardController extends ControllerBase
{
    public function indexAction()
    {
        $chefDeProjets = Chefdeprojet::find();
        $devs = Developpeur::find();

        $htmlContent = "";

        $htmlContent .= '<form action="/phalcon/dashboard/createTeam" method="post">';
        $htmlContent .= '<label class="mb-2 fs-3" for="teamname">Nom de l\'équipe :</label>';
        $htmlContent .= '<br>';
        $htmlContent .= '<input class="mb-2" type="text" id="teamname" name="teamname" required minlength="4" maxlength="24" size="10">';
        $htmlContent .= '<br>';
        $htmlContent .= '<label class="mb-2 fs-3" for="selectOption">Choisir un chef de projet :</label>';
        $htmlContent .= '<br>';
        $htmlContent .= '<select class="mb-2 w-25"  name="chefdeprojet" id="chefdeprojet-select">';
        foreach ($chefDeProjets as $chefDeProjet)
        {
            $htmlContent .= '<option   value=' . '"' . $chefDeProjet->getId() . '">' . $chefDeProjet->Collaborateur->getPrenomNom(). '</option>';
        }
        $htmlContent .= '</select>';
        $htmlContent .= '<br>';
        $htmlContent .= '<label class="mb-2 fs-3" for="selectOption">Choisir les developpeurs de votre equipes :</label>';
        $htmlContent .= '<br>';
        foreach ($devs as $dev){
            $htmlContent .= '<label>';
            $htmlContent .= '<input type="checkbox" name="dev[]" value=' . '"' . $dev->getId() . '"' . 'onclick="limitCheckboxes(3)">';
            $htmlContent .= ' ';
            $htmlContent .= $dev->Collaborateur->getPrenomNom() . " (" . $dev->enumNivCompetence() . ")";
            $htmlContent .= '</label>';
            $htmlContent .= '<br>';
        }
        $htmlContent .= '<input class="mt-2" type="submit" value="Submit">';
        $htmlContent .= '</form>';

        $this->view->chefdeprojet = $htmlContent;
    }


    /**  Methode permettant la création d'une equipe , Une equipe est crée avec un nom et un chef de projet ,
     * une fois que l'equipe est crée on crée la composition de l'equipe a partir de l'id de l'equipe et les developpeurs qui la compose
     */
    public  function  createTeamAction()
    {
        if($this->request->isPost()){
            $equipe = (new Team())
                ->setName($this->request->getPost("teamname"))
                ->setChefdeprojetId($this->request->getPost("chefdeprojet"));

            if($equipe->save())
            {
                foreach ($this->request->getPost("dev") as $dev)
                {
                    (new CompositionEquipe())
                        ->setIdTeam($equipe->getId())
                        ->setIdDev($dev)
                        ->save();
                }
            }
            return $this->response->redirect("/phalcon/equipe");
        }

        return 'The request method is not POST';
    }

}
