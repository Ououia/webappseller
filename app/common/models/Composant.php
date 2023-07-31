<?php

namespace Phalcon\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\ResultInterface;
use Phalcon\Mvc\Model\ResultsetInterface;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Validation;
use Phalcon\Validation\Validator\InclusionIn;

class Composant extends Model
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
     * @Column(column="libelle", type="string", length=255, nullable=true)
     */
    protected $libelle;

    /**
     *
     * @var string
     * @Column(column="competence", type="string", length='1','2','3', nullable=true)
     */
    protected $competence;

    /**
     *
     * @var integer
     * @Column(column="charge", type="integer", nullable=true)
     */
    protected $charge;

    /**
     *
     * @var integer
     * @Column(column="progression", type="integer", nullable=true)
     */
    protected $progression;

    /**
     *
     * @var integer
     * @Column(column="module_id", type="integer", nullable=true)
     */
    protected $module_id;

    const _COMPETENCE_1_FRONTEND_ = 1;
    const _COMPETENCE_2_BACKEND_ = 2;
    const _COMPETENCE_3_DATABASE_ = 3;

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
     * Method to set the value of field libelle
     *
     * @param string $libelle
     * @return $this
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

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
     * Method to set the value of field charge
     *
     * @param integer $charge
     * @return $this
     */
    public function setCharge($charge)
    {
        $this->charge = $charge;

        return $this;
    }

    /**
     * Method to set the value of field progression
     *
     * @param integer $progression
     * @return $this
     */
    public function setProgression($progression)
    {
        $this->progression = $progression;

        return $this;
    }

    /**
     * Method to set the value of field module_id
     *
     * @param integer $module_id
     * @return $this
     */
    public function setModuleId($module_id)
    {
        $this->module_id = $module_id;

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
     * Returns the value of field libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Returns the value of field competence
     *
     * @return string
     */
    public function getCompetence()
    {
        return intval($this->competence);
    }


    /**
     * Returns a string representing the competence area (Frontend, Backend, Database) based on the object's competence value.
     * If the competence is not recognized, it returns 'type unknown'.
     */
    public function getCompetenceLibele() : string
    {
        switch ($this->getCompetence()) {
            case  self::_COMPETENCE_1_FRONTEND_:return "Frontend";
            case  self::_COMPETENCE_2_BACKEND_ :return "Backend";
            case  self::_COMPETENCE_3_DATABASE_ :return "Database";
            default:return 'type unknown';
        }
    }

    /**
     * Returns the value of field charge
     *
     * @return integer
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     * Returns the value of field progression
     *
     * @return integer
     */
    public function getProgression()
    {
        return $this->progression;
    }

    /**
     * Returns the value of field module_id
     *
     * @return integer
     */
    public function getModuleId()
    {
        return $this->module_id;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("webappseller");
        $this->setSource("composant");
        $this->hasMany('id', 'Phalcon\Models\Projet', 'id_composant', ['alias' => 'Projet']);
        $this->belongsTo('module_id', 'Phalcon\Models\Module', 'id', ['alias' => 'Module']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Composant[]|Composant|ResultSetInterface
     */
    public static function find($parameters = null): ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Composant|ResultInterface|ModelInterface|null
     */
    public static function findFirst($parameters = null): ?ModelInterface
    {
        return parent::findFirst($parameters);
    }


    /**
     * @return bool
     */
    public function validation(): bool
    {
        $validator = new Validation();
        $validator->add(
            "competence",
                new InclusionIn(
                    [
                    "template" => "test",
                    "message" => 'test',
                    'domain' => [
                        self::_COMPETENCE_1_FRONTEND_,
                        self::_COMPETENCE_2_BACKEND_,
                        self::_COMPETENCE_3_DATABASE_,
                    ],
                ]
                )
        );
        return $this->validate($validator);
    }
}
