<?php

namespace Phalcon\Models;

class Developpeur extends \Phalcon\Mvc\Model
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
     * @var integer
     * @Column(column="collaborateur_id", type="integer", nullable=true)
     */
    protected $collaborateur_id;

    /**
     *
     * @var string
     * @Column(column="competence", type="string", length='1','2','3', nullable=true)
     */
    protected $competence;

    /**
     *
     * @var integer
     * @Column(column="indice_production", type="integer", nullable=true)
     */
    protected $indice_production;

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
     * Method to set the value of field collaborateur_id
     *
     * @param integer $collaborateur_id
     * @return $this
     */
    public function setCollaborateurId($collaborateur_id)
    {
        $this->collaborateur_id = $collaborateur_id;

        return $this;
    }

    /**
     * Method to set the value of field competence
     *
     * @param string $competence
     * @return $this
     */
    public function setCompetence($competence)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Method to set the value of field indice_production
     *
     * @param integer $indice_production
     * @return $this
     */
    public function setIndiceProduction($indice_production)
    {
        $this->indice_production = $indice_production;

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
     * Returns the value of field collaborateur_id
     *
     * @return integer
     */
    public function getCollaborateurId()
    {
        return $this->collaborateur_id;
    }

    /**
     * Returns the value of field competence
     *
     * @return string
     */
    public function getCompetence()
    {
        return $this->competence;
    }

    /**
     * Returns the value of field indice_production
     *
     * @return integer
     */
    public function getIndiceProduction()
    {
        return $this->indice_production;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("webappseller");
        $this->setSource("developpeur");
        $this->hasMany('id', 'Phalcon\Models\CompositionEquipe', 'id_dev', ['alias' => 'CompositionEquipe']);
        $this->hasMany('id', 'Phalcon\Models\Projet', 'id_developpeur', ['alias' => 'Projet']);
        $this->belongsTo('collaborateur_id', 'Phalcon\Models\Collaborateur', 'id', ['alias' => 'Collaborateur']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Developpeur[]|Developpeur|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Developpeur|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
