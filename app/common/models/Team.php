<?php

namespace Phalcon\Models;

use Phalcon\Escaper;
use Phalcon\Flash\Direct;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\ResultInterface;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Mvc\ModelInterface;

class Team extends Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", nullable=false)
     */
    protected $id;

    /**
     *
     * @var string
     * @Column(column="name", type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     *
     * @var integer
     * @Column(column="chefdeprojet_id", type="integer", nullable=true)
     */
    protected $chefdeprojet_id;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field chefdeprojet_id
     *
     * @param integer $chefdeprojet_id
     * @return $this
     */
    public function setChefdeprojetId($chefdeprojet_id)
    {
        $this->chefdeprojet_id = $chefdeprojet_id;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field chefdeprojet_id
     *
     * @return integer
     */
    public function getChefdeprojetId()
    {
        return $this->chefdeprojet_id;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("webappseller");
        $this->setSource("team");
        $this->hasMany('id', 'Phalcon\Models\CompositionEquipe', 'id_team', ['alias' => 'CompositionEquipe']);
        $this->belongsTo('chefdeprojet_id', 'Phalcon\Models\Chefdeprojet', 'id', ['alias' => 'Chefdeprojet']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Team[]|Team|ResultSetInterface
     */
    public static function find($parameters = null): ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Team|ResultInterface|ModelInterface|null
     */
    public static function findFirst($parameters = null): ?ModelInterface
    {
        return parent::findFirst($parameters);
    }

    public function checkAddTeam(int $cdp, array $devs) : array
    {
        $teams = Team::find([
            'conditions' => 'chefdeprojet_id = :cdp:',
            'bind'       => ['cdp' => $cdp]
        ]);

        $devNames = [];

        foreach ($teams as $team) {
            foreach ($team->CompositionEquipe as $compo) {
                if (in_array($compo->getIdDev(), $devs)) {
                    $devNames[] = $compo->Developpeur->Collaborateur->getPrenomNom();
                }
            }
        }
        return $devNames;
    }


    public function addTeam(string $name, $cdp, array $devs)
    {
        $equipe = ($this)
            ->setName($name)
            ->setChefdeprojetId($cdp);

        if (!$equipe->save()) {
            return false;
        }

        foreach ($devs as $dev) {
            $compositionEquipe = (new CompositionEquipe())
                ->setIdTeam($equipe->getId())
                ->setIdDev($dev);

            if (!$compositionEquipe->save()) {
                return false;
            }
        }

        return true;
    }
}
