<?php

namespace Phalcon\Models;

class Team extends \Phalcon\Mvc\Model
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
     * @return Team[]|Team|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Team|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
