<?php
/**
 * Created by PhpStorm.
 * User: miki
 * Date: 01.01.2016
 * Time: 19:55
 */

namespace Transp\Commands;


use DateTime;

class AbstractTaskSearchCommand
{

    /**
     * @var \DateTime
     */
    protected $startDate;
    /**
     * @var \DateTime
     */
    protected $endDate;
    


    /**
     * @param string $startDate
     * @return StatsSearchCommand
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $this->getDateFromString($startDate);
        return $this;
    }

    /**
     * @param string $endDate
     * @return StatsSearchCommand
     */
    public function setEndDate($endDate)
    {

        $this->endDate = $this->getDateFromString($endDate);
        return $this;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }
    
        
        /**
         * @param string $startDate
         * @return \DateTime
         */
    private function getDateFromString($dateStr){
        if (strlen($dateStr) > 2) {
                    $date = DateTime::createFromFormat("d/m/Y", $startDate);
                    $date->setTime(0, 0, 1);
                    return $date;
                }
         return null;
    }

}