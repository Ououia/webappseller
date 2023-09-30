<?php
declare(strict_types=1);

namespace Phalcon\modules\frontend\controllers;



use Phalcon\Models\Projet;
use \Phalcon\Modules\Frontend\Controllers\ControllerBase;

class ProjetController extends ControllerBase
{
    /** Formulaire de création de projet */
    public function indexAction()
    {
        $projets = Projet::find();

        $table = '';

        $table .= '<h2 class="text-capitalize">Projets :</h2>';
        foreach ($projets as $projet) {
            $table .= '<table class="table">';
            $table .= '<thead>';
            $table .= '<tr>';
            $table .= '<th>Client</th>';
            $table .= '<th>Nom de l\'application</th>';
            $table .= '<th>Prix</th>';
            $table .= '<th>Status</th>';
            if (!empty($projet->Developpeur)) {
                $table .= '<th>Developpeur</th>';
            } else if (!empty($projet->Chefdeprojet)) {
                $table .= '<th>Chef de projet</th>';
            } else {
                $table .= '<th>Ressources</th>';
            }
            $table .= '</tr>';
            $table .= '</thead>';
            $table .= '<tbody>';
            $table .= '<tr>';
            $table .= '<td>' . $projet->Client->getRaisonSociale() . '</td>';
            $table .= '<td>' . $projet->Application->getName() . '</td>';
            $table .= '<td>' . $projet->getPrix() . '</td>';
            $table .= '<td>' . $projet->enumStatutProjet() . '</td>';
            if (!empty($projet->Developpeur)) {
                $table .= '<th>' . $projet->Developpeur->Collaborateur->getPrenomNom() . '</th>';
            } else if (!empty($projet->Chefdeprojet)) {
                $table .= '<th>' . $projet->Chefdeprojet->Collaborateur->getPrenomNom() . '</th>';
            } else {
                $table .= '<td>Aucun developpeur ou équipe associé</td>';
            }
            $table .= '</tr>';
            $table .= '</tbody>';
            $table .= '</table>';

            $this->view->setVar('table', $table);
        }
    }

}