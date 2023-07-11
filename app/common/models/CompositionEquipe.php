<?php

class CompositionEquipe extends \Phalcon\Mvc\Model
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
     * @Column(column="id_team", type="integer", nullable=true)
     */
    protected $id_team;

    /**
     *
     * @var integer
     * @Column(column="id_dev", type="integer", nullable=true)
     */
    protected $id_dev;

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
     * Method to set the value of field id_team
     *
     * @param integer $id_team
     * @return $this
     */
    public function setIdTeam($id_team)
    {
        $this->id_team = $id_team;

        return $this;
    }

    /**
     * Method to set the value of field id_dev
     *
     * @param integer $id_dev
     * @return $this
     */
    public function setIdDev($id_dev)
    {
        $this->id_dev = $id_dev;

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
     * Returns the value of field id_team
     *
     * @return integer
     */
    public function getIdTeam()
    {
        return $this->id_team;
    }

    /**
     * Returns the value of field id_dev
     *
     * @return integer
     */
    public function getIdDev()
    {
        return $this->id_dev;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("webappseller");
        $this->setSource("composition_equipe");
        $this->belongsTo('id_dev', '\Developpeur', 'id', ['alias' => 'Developpeur']);
        $this->belongsTo('id_team', '\Team', 'id', ['alias' => 'Team']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CompositionEquipe[]|CompositionEquipe|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CompositionEquipe|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
