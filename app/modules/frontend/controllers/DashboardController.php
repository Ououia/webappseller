<?php
declare(strict_types=1);

namespace Phalcon\modules\frontend\controllers;


use mysql_xdevapi\Exception;
use Phalcon\Models\Chefdeprojet;
use Phalcon\Models\Composant;
use Phalcon\Models\CompositionEquipe;
use Phalcon\Models\Developpeur;
use Phalcon\Models\Team;
use Phalcon\Mvc\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $chefDeProjets = Chefdeprojet::find();
        $devs = Developpeur::find();

        $selectChefDeProjets = "";

        $selectChefDeProjets .= '<form action="/phalcon/dashboard/createTeam" method="post">';
        $selectChefDeProjets .= '<label class="mb-2 fs-3" for="teamname">Nom de l\'equipe :</label>';
        $selectChefDeProjets .= '<br>';
        $selectChefDeProjets .= '<input class="mb-2" type="text" id="teamname" name="teamname" required minlength="4" maxlength="24" size="10">';
        $selectChefDeProjets .= '<br>';
        $selectChefDeProjets .= '<label class="mb-2 fs-3" for="selectOption">Choisir un chef de projet :</label>';
        $selectChefDeProjets .= '<br>';
        $selectChefDeProjets .= '<select class="mb-2"  name="chefdeprojet" id="chefdeprojet-select">';
        foreach ($chefDeProjets as $chefDeProjet)
        {
            $selectChefDeProjets .= '<option   value=' . '"' . $chefDeProjet->getId() . '">' . $chefDeProjet->Collaborateur->getPrenomNom(). '</option>';
        }
        $selectChefDeProjets .= '</select>';
        $selectChefDeProjets .= '<br>';
        $selectChefDeProjets .= '<label class="mb-2 fs-3" for="selectOption">Choisir les developpeurs de votre equipes :</label>';
        $selectChefDeProjets .= '<br>';
        foreach ($devs as $dev){
            $selectChefDeProjets .= '<label>';
            $selectChefDeProjets .= '<input type="checkbox" name="dev[]" value=' . '"' . $dev->getId() . '"' . 'onclick="limitCheckboxes(3)">';
            $selectChefDeProjets .= ' ';
            $selectChefDeProjets .= $dev->Collaborateur->getPrenomNom() . " (" . $dev->enumNivCompetence() . ")";
            $selectChefDeProjets .= '</label>';
            $selectChefDeProjets .= '<br>';
        }
        $selectChefDeProjets .= '<input class="mt-2" type="submit" value="Submit">';
        $selectChefDeProjets .= '</form>';

        $this->view->chefdeprojet = $selectChefDeProjets;
    }

    public  function  createTeamAction()
    {

        if($this->request->isPost()){
            $equipe = new Team();
            $equipe->setName($this->request->getPost("teamname"))->setChefdeprojetId($this->request->getPost("chefdeprojet"))->save();

            if($equipe->save())
            {
                foreach ($this->request->getPost("dev") as $dev)
                {
                    (new CompositionEquipe())->setIdTeam($equipe->getId())->setIdDev($dev)->save();
                }
            }

            return $this->response->redirect("/phalcon/equipe");
        }


    }

}
