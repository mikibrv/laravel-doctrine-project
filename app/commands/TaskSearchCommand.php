<?php
/**
 * User: mcsere
 * Date: 12/8/14
 * Time: 4:56 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Commands;


use DateTime;

class TaskSearchCommand extends AbstractTaskSearchCommand
{

    private $filter;
    private $filterArray;
    private $lowerLimit;
    private $noResults;
    private $isForCount;
    private $tipCursa;


    private $splitDetails = false;

    public function showOnlyFuture()
    {
        if ($this->startDate == null && $this->endDate == null) {
            return true;
        }
        return false;
    }

    /**
     * @param mixed $filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return mixed
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param mixed $isForCount
     */
    public function setIsForCount($isForCount)
    {
        $this->isForCount = $isForCount;
    }

    /**
     * @return mixed
     */
    public function getIsForCount()
    {
        return $this->isForCount;
    }

    /**
     * @param mixed $lowerLimit
     */
    public function setLowerLimit($lowerLimit)
    {
        $this->lowerLimit = $lowerLimit;
    }

    /**
     * @return mixed
     */
    public function getLowerLimit()
    {
        return $this->lowerLimit;
    }

    /**
     * @param mixed $noResults
     */
    public function setNoResults($noResults)
    {
        $this->noResults = $noResults;
    }

    /**
     * @return mixed
     */
    public function getNoResults()
    {
        return $this->noResults;
    }

    /**
     * @param mixed $filterArray
     */
    public function setFilterArray($filterArray)
    {
        $this->filterArray = $filterArray;
    }

    /**
     * @return mixed
     */
    public function getFilterArray()
    {
        return $this->filterArray;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        if (strlen($endDate) > 2) {
            $date = DateTime::createFromFormat("d/m/Y", $endDate);
            $date->setTime(23, 59, 59);
            $this->endDate = $date;
        }
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        if (strlen($startDate) > 2) {
            $date = DateTime::createFromFormat("d/m/Y", $startDate);
            $date->setTime(0, 0, 1);
            $this->startDate = $date;
        }
    }

    public function setDateStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $tipCursa
     */
    public function setTipCursa($tipCursa)
    {
        $this->tipCursa = $tipCursa;
    }

    /**
     * @return mixed
     */
    public function getTipCursa()
    {
        return $this->tipCursa;
    }

    /**
     * @param mixed $splitDetails
     */
    public function setSplitDetails($splitDetails)
    {
        $this->splitDetails = $splitDetails;
    }

    /**
     * @return mixed
     */
    public function getSplitDetails()
    {
        return $this->splitDetails;
    }


}