<?php
declare(strict_types=1);

namespace Phalcon\modules\frontend\controllers;


use Phalcon\Http\Response;
use Phalcon\Models\Collaborateur;
use Phalcon\Models\CompositionEquipe;
use Phalcon\Models\Developpeur;
use Phalcon\Models\Team;
use \Phalcon\Modules\Frontend\Controllers\ControllerBase;

class EquipeController extends ControllerBase
{
    /** tableau des equipes */
    public function indexAction()
    {
        $equipes = Team::find();

        $table = '';
        foreach ($equipes as $equipe){

            $dev = $equipe->getRelated('CompositionEquipe');

            $table .= '<h2>'. $equipe->getName() .'<button data-delete-team=' . '"'. $equipe->getId() .'"'.  ' title="Supprimer cette equipe" type="button" class="btn btn-for-delete" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash" style="color: #ff0000;"></i></button>' . '</h2>';
            $table .= '<table class="table">';
            $table .= '<thead>';
            $table .= '<tr>';
            $table .= '<th>Role</th>';
            $table .= '<th>Nom</th>';
            $table .= '<th>Niveau Competence</th>';
            $table .= '</tr>';
            $table .= '</thead>';
            $table .= '<tbody>';
            $table .= '<tr>';
            $table .= '<td>Chef de projet <i class="fa-solid fa-crown" style="color: #d3d600;"></i></td>';
            $table .= '<td>' . $equipe->Chefdeprojet->Collaborateur->getPrenomNom() .'</td>';
            $table .= '<td>' . $equipe->Chefdeprojet->Collaborateur->getCompetenceLibele() .'</td>';
            $table .= '</tr>';
            foreach ($dev as $d){
                $table .= '<tr>';
                $table .= '<td> Developpeur ' . $d->Developpeur->enumNivCompetence() .'</td>';
                $table .= '<td>' . $d->Developpeur->Collaborateur->getPrenomNom() .'</td>';
                $table .= '<td>' . $d->Developpeur->Collaborateur->getCompetenceLibele() .'</td>';
                $table .= '<td><button data-team =' . '"'. $equipe->getId() .'"'.  '   data-modify-team=' . '"'. $d->Developpeur->getId() .'"'.  '  class="button-for-modify btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#modifyModal">Modifier</button></td>';
                $table .= '</tr>';
            }
            $table .= '</tbody>';
            $table .= '</table>';
        }

        $this->view->setVar('table', $table);

    }

    public function getAvailableDevsAction(): \Phalcon\Http\ResponseInterface
    {
        $response = new Response();

        /** Cherche l'equipe du developpeur selectionner  */
        $teamId = $this->request->get('teamid', "int");

        $devsInTeam = CompositionEquipe::find([
            "conditions" => "id_team = :teamId:",
            "bind" => ["teamId" => $teamId]
        ]);


        /** crée un tableau avec les id des developpeurs present dans l'equipe du developpeur qu on veut modifier */
        $excludeDevIds = [];
        foreach ($devsInTeam as $composition) {
            $excludeDevIds[] = $composition->getIdDev();
        }

        /** Recupere tout les developpeurs sauf ceux present dans l'equipe du developpeur selectionner pour la modification */
        $developers = Developpeur::find([
            "conditions" => "id NOT IN ({devIds:array})",
            "bind" => ["devIds" => $excludeDevIds]
        ]);

        /** Retourne un json avec l'id de et le nom de chaque developpeur qui peuvent intégré l'equipe  */
        $developerInfo = [];
        foreach ($developers as $dev) {
            $developerInfo[] = [
                'id' => $dev->getId(),
                'name' => $dev->Collaborateur->getPrenomNom()
            ];
        }

        $response->setJsonContent([
            "status" => "success",
            "developers" => $developerInfo
        ]);
        return $response->send();
    }


    /** Permet de supprimer une equipe par rapport a son id */
    public function deleteAction(): \Phalcon\Http\ResponseInterface
    {
        $team = Team::findFirst($this->request->get("teamid"));

        $error = false;
        if(!empty($team))
        {
            foreach ($team->CompositionEquipe as $teamComposition) {
                if (!$teamComposition->delete()) {
                    $error = true;
                }
            }

            if (!$error) $team->delete();
        }
        return $this->response->redirect("/phalcon/equipe");

//        if($this->request->get("teamid")){
//            foreach (CompositionEquipe::find('id_team =' .  $this->request->get("teamid")) as $teamCompositionLigne) {
//                $teamCompositionLigne->delete();
//            }
//            if(count(CompositionEquipe::find('id_team =' .  $this->request->get("teamid"))) === 0){
//               Team::find($this->request->get("teamid"))->delete();
//            }
//            return $this->response->redirect("/phalcon/equipe");
//        } else {
//            return "Il y a eu une erreur lors de la suppression";
//        }
    }
}
