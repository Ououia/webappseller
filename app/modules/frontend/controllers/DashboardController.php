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
    /** Formulaire de création d'equipe */
    public function indexAction()
    {
        $chefDeProjets = Chefdeprojet::find();
        $devs = Developpeur::find();

        $htmlContent = "";

        $htmlContent .= '<form action=' .  $this->url->get(PROJECT_PATH . "/dashboard/createTeam") .' method="post">';
        $htmlContent .= '<label class="mb-2 fs-3" for="teamname">Nom de l\'équipe :</label>';
        $htmlContent .= '<br>';
        $htmlContent .= '<input class="mb-2" type="text" id="teamname" name="teamname" required minlength="4" maxlength="24" size="10">';
        $htmlContent .= '<br>';
        $htmlContent .= '<label class="mb-2 fs-3" for="selectOption">Choisir un chef de projet :</label>';
        $htmlContent .= '<br>';
        $htmlContent .= '<select class="mb-2 w-25"  name="chefdeprojet" id="chefdeprojet-select">';
        foreach ($chefDeProjets as $chefDeProjet) {
            $htmlContent .= '<option   value=' . '"' . $chefDeProjet->getId() . '">' . $chefDeProjet->Collaborateur->getPrenomNom() . '</option>';
        }
        $htmlContent .= '</select>';
        $htmlContent .= '<br>';
        $htmlContent .= '<label class="mb-2 fs-3" for="selectOption">Choisir les developpeurs de votre equipes :</label>';
        $htmlContent .= '<br>';
        foreach ($devs as $dev) {
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
    public function createTeamAction()
    {
        // Récupérer l'URL d'origine
        $referer = $this->request->getHTTPReferer();

        if ($this->request->isPost()) {
            $teamModel = new Team();
            $conflictDev = $teamModel->checkAddTeam(
                (int) $this->request->getPost("chefdeprojet"),
                $this->request->getPost("dev")
            );

            // Si aucun développeur en conflit n'est trouvé, procéder à l'ajout de l'équipe
            if (count($conflictDev) === 0) {
                $newTeam = $teamModel->addTeam(
                    $this->request->getPost("teamname"),
                    $this->request->getPost("chefdeprojet"),
                    $this->request->getPost("dev")
                );

                if ($newTeam) {
                    $this->flashSession->success("Équipe créée avec succès");
                    return $this->response->redirect($referer);
                } else {
                    $this->flashSession->error("Il y a eu une erreur lors de la création de l'équipe.");
                    return $this->response->redirect($referer);
                }
            } else {
                $this->flashSession->error("Le développeur " . implode("," , $conflictDev) . " est déjà dans une équipe avec ce chef de projet.");
                return $this->response->redirect($referer);
            }
        } else {
            $this->flashSession->error("La requête n'est pas de type POST");
            return $this->response->redirect($referer);
        }
    }

}
