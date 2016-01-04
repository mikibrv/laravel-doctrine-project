<?php
/**
 * Created by PhpStorm.
 * User: miki
 * Date: 01.01.2016
 * Time: 18:34
 */

namespace Transp\Commands;


class StatsSearchCommand extends AbstractTaskSearchCommand
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var integer
     */
    public $distance;

    /**
     * @var string
     */
    private $criteria;

    /**
     * @var
     */
    private $oldValue;

    /**
     * @var string
     */
    private $newValue;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return StatsSearchCommand
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param int $distance
     * @return StatsSearchCommand
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * @return string
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param string $criteria
     * @return StatsSearchCommand
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOldValue()
    {
        return $this->oldValue;
    }

    /**
     * @param mixed $oldValue
     * @return StatsSearchCommand
     */
    public function setOldValue($oldValue)
    {
        $this->oldValue = $oldValue;
        return $this;
    }

    /**
     * @return string
     */
    public function getNewValue()
    {
        return $this->newValue;
    }

    /**
     * @param string $newValue
     * @return StatsSearchCommand
     */
    public function setNewValue($newValue)
    {
        $this->newValue = $newValue;
        return $this;
    }


}