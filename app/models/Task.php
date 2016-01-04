<?php
/**
 * User: mcsere
 * Date: 11/28/14
 * Time: 4:46 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Entities;


use DateTime;
use Mitch\LaravelDoctrine\Traits\SoftDeletes;
use Mitch\LaravelDoctrine\Traits\Timestamps;
use Transp\Entities\EntityTraits\EntityID;
use Transp\Entities\EntityTraits\JSerialize;
use Transp\Entities\Interf\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tasks", indexes={
 *     @ORM\Index(name="tip_cursa", columns={"cursa"}),
 *     @ORM\Index(name="sofer", columns={"sofer"})
 * })
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Task extends AbstractEntity
{

    use EntityID;
    use SoftDeletes;
    use Timestamps;
    use JSerialize;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateTime;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $dataString;


    /**
     * @ORM\Column(type="string",  nullable=true)
     */
    private $oraText;


    /**
     * @ORM\Column(type="string",  nullable=true)
     */
    private $client;


    /**
     * @ORM\Column(type="string",  nullable=true)
     */
    private $cursa;


    /**
     * @ORM\Column(type="string",  nullable=true)
     */
    private $vehicle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $vehicleNo;


    /**
     * @ORM\Column(type="string",  nullable=true)
     */
    private $traseu;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $distance;


    /**
     * @ORM\Column(type="string",  nullable=true)
     */
    private $sofer;


    /**
     * @ORM\Column(type="string",  nullable=true)
     */
    private $bani;


    /**
     * @ORM\Column(type="string",  nullable=true)
     */
    private $detalii;

    /**
     * @ORM\Column(type="string", length = 500,  nullable=true)
     */
    private $fullTask;

    /**
     * Contains username-date|username-date. newest is added in front
     * @ORM\Column(type="string", length = 1000,  nullable=true)
     */
    private $editHistory;

    /**
     * @return mixed
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param mixed $dateTime
     * @return Task
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataString()
    {
        return $this->dataString;
    }

    /**
     * @param mixed $dataString
     * @return Task
     */
    public function setDataString($dataString)
    {
        $this->dataString = $dataString;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOraText()
    {
        return $this->oraText;
    }

    /**
     * @param mixed $oraText
     * @return Task
     */
    public function setOraText($oraText)
    {
        $this->oraText = $oraText;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     * @return Task
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCursa()
    {
        return $this->cursa;
    }

    /**
     * @param mixed $cursa
     * @return Task
     */
    public function setCursa($cursa)
    {
        $this->cursa = $cursa;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @param mixed $vehicle
     * @return Task
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVehicleNo()
    {
        return $this->vehicleNo;
    }

    /**
     * @param mixed $vehicleNo
     * @return Task
     */
    public function setVehicleNo($vehicleNo)
    {
        $this->vehicleNo = $vehicleNo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTraseu()
    {
        return $this->traseu;
    }

    /**
     * @param mixed $traseu
     * @return Task
     */
    public function setTraseu($traseu)
    {
        $this->traseu = $traseu;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     * @return Task
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSofer()
    {
        return $this->sofer;
    }

    /**
     * @param mixed $sofer
     * @return Task
     */
    public function setSofer($sofer)
    {
        $this->sofer = $sofer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBani()
    {
        return $this->bani;
    }

    /**
     * @param mixed $bani
     * @return Task
     */
    public function setBani($bani)
    {
        $this->bani = $bani;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDetalii()
    {
        return $this->detalii;
    }

    /**
     * @param mixed $detalii
     * @return Task
     */
    public function setDetalii($detalii)
    {
        $this->detalii = $detalii;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFullTask()
    {
        return $this->fullTask;
    }

    /**
     * @param mixed $fullTask
     * @return Task
     */
    public function setFullTask($fullTask)
    {
        $this->fullTask = $fullTask;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEditHistory()
    {
        return $this->editHistory;
    }

    /**
     * @param mixed $editHistory
     * @return Task
     */
    public function setEditHistory($editHistory)
    {
        $this->editHistory = $editHistory;
        return $this;
    }

}