<?php
declare(strict_types=1);

namespace Phalcon\modules\frontend\controllers;


use Phalcon\Models\Composant;
use Phalcon\Mvc\Controller;

class ComposantController extends Controller
{
    public function indexAction()
    {
        $composants = Composant::find();

        $comp = [];

        foreach ($composants as $composant) {
            $libelle = '<td>' . $composant->getLibelle() . '</td>';
            $competence = '<td>' . $composant->getCompetence() . '</td>';
            $charge = '<td>' . $composant->getCharge() . '</td>';
            $modulelibelle = '<td>' . $composant->getRelated("Module")->getLibelle() . '</td>';

            $comp[] = ['libelle' => $libelle, 'competence' => $competence, 'charge' => $charge, 'modulelibelle' => $modulelibelle];
        }

        $this->view->comp = $comp;
    }

}