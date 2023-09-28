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
        foreach ($equipes as $equipe) {

            $dev = $equipe->getRelated('CompositionEquipe');

            $table .= '<h2>' . $equipe->getName() . '<button data-delete-team=' . '"' . $equipe->getId() . '"' . ' title="Supprimer cette equipe" type="button" class="btn btn-for-delete" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash fa-xl" style="color: #ff0000;"></i></button>' . '</h2>';
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
            $table .= '<td>' . $equipe->Chefdeprojet->Collaborateur->getPrenomNom() . '</td>';
            $table .= '<td>' . $equipe->Chefdeprojet->Collaborateur->getCompetenceLibele() . '</td>';
            $table .= '</tr>';
            foreach ($dev as $d) {
                $table .= '<tr>';
                $table .= '<td> Developpeur ' . $d->Developpeur->enumNivCompetence() . '</td>';
                $table .= '<td>' . $d->Developpeur->Collaborateur->getPrenomNom() . '</td>';
                $table .= '<td>' . $d->Developpeur->Collaborateur->getCompetenceLibele() . '</td>';
                $table .= '<td><button  data-compoid =' . '"' . $d->getId() . '"' . '  data-cdp =' . '"' . $equipe->Chefdeprojet->getId() . '"' . 'data-team =' . '"' . $equipe->getId() . '"' . '  class="button-for-modify btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#modifyModal">Modifier</button></td>';
                $table .= '</tr>';
            }
            $table .= '</tbody>';
            $table .= '</table>';
        }

        $this->view->setVar('table', $table);
    }


    public function modifyDevInTeamAction(): \Phalcon\Http\ResponseInterface
    {
        if ($this->request->isPost()) {
            $referer = $this->request->getHTTPReferer();

            $compoId = $this->request->get('compoId', "int");
            $newDevId = $this->request->get('newDevName', "int");

            if ($compoId && $newDevId) {
                try {
                    $compositionEquipe = CompositionEquipe::findFirst($compoId);

                    if ($compositionEquipe) {
                        // Update the 'devid' field
                        $compositionEquipe->setIdDev($newDevId);

                        // Save the updated record
                        if ($compositionEquipe->save()) {
                            $this->flashSession->success("Developpeur modifié avec succes");
                            return $this->response->redirect($referer);
                        } else {
                            $this->flashSession->error("Il y a eu une erreur lors de la modification");
                            return $this->response->redirect($referer);
                        }
                    } else {
                        $this->flashSession->error("Désolé nous avons pas trouvé ce developpeur");
                        return $this->response->redirect($referer);
                    }
                } catch (\Exception $e) {
                    $this->flashSession->error("Il y a eu une erreur lors de la modification de l'équipe.");
                    return $this->response->redirect($referer);
                }
            }
            $this->flashSession->error("Il y a eu une erreur, veuillez reesayer");
            return $this->response->redirect($referer);
        } else {
            return $this->flashSession->error("La requête n'est pas de type POST");
        }
    }

    /** Permet de modifier un developpeur dans une equipe donnée */
    public function getAvailableDevsAction(): \Phalcon\Http\ResponseInterface
    {
        $response = new Response();

        if ($this->request->isGet()) {
            /** recupere les equipes avec les memes chef de projet et ensuite les developpeurs qui sont dans ces equipes */
            $teamIds = Team::getTeamsByChefdeprojetId($this->request->get("cdpid", "int")) ?? [];

            if (isset($teamIds['error']) && $teamIds['error'] === true) {
                $response->setJsonContent([
                    "status" => "Error",
                ]);
                return $response->send();
            }

            $devIds = CompositionEquipe::getDevsByTeamIds($teamIds);

            /** crée un tableau avec les id des developpeurs present dans l'equipe du developpeur qu on veut modifier */
            $excludeDevIds = [];
            foreach ($devIds as $devIdToExclude) {
                $excludeDevIds[] = $devIdToExclude;
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
                    'name' => $dev->Collaborateur->getPrenomNom(),
                    'competence' => $dev->enumNivCompetence()
                ];
            }

            $response->setJsonContent([
                "status" => "success",
                "developers" => $developerInfo
            ]);
            return $response->send();
        } else {
            $response->setJsonContent([
                "status" => "Error",
            ]);
            return $response->send();
        }
    }


    /** Permet de supprimer une equipe par rapport a son id */
    public function deleteAction(): \Phalcon\Http\ResponseInterface
    {
        $team = Team::findFirst($this->request->get("teamid"));

        $error = false;
        if (!empty($team)) {
            foreach ($team->CompositionEquipe as $teamComposition) {
                if (!$teamComposition->delete()) {
                    $error = true;
                }
            }

            if (!$error)
                $team->delete();
        }
        return $this->response->redirect($this->url->get("/equipe"));
    }
}