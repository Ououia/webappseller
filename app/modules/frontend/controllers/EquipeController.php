<?php
declare(strict_types=1);

namespace Phalcon\modules\frontend\controllers;


use Phalcon\Models\Collaborateur;
use Phalcon\Models\CompositionEquipe;
use Phalcon\Models\Team;
use Phalcon\Mvc\Controller;

class EquipeController extends Controller
{
    public function indexAction()
    {
        $equipes = Team::find();

        $table = '';
        foreach ($equipes as $equipe){

            $dev = $equipe->getRelated('CompositionEquipe');

            $table .= '<h2>'. $equipe->getName() .'</h2>';
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
                $table .= '</tr>';
            }
            $table .= '</tbody>';
            $table .= '</table>';
        }




        $this->view->setVar('table', $table);

    }


}
