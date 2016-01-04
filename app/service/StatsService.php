<?php
/**
 * Created by PhpStorm.
 * User: miki
 * Date: 01.01.2016
 * Time: 18:31
 */

namespace Transp\Service;


use Transp\Commands\StatsSearchCommand;
use Transp\Commands\TaskSearchCommand;
use Transp\Service\Interf\AbstractService;
use Transp\Service\Traits\CacheTrait;


interface IStatsService
{

    /**
     * @param $command StatsSearchCommand
     * @return StatsSearchCommand[]
     */
    public function findStatsByType($command);

    /**
     * @param $command StatsSearchCommand
     * @return mixed
     */
    public function updateStatsByCriteria($command);

}


class StatsService extends AbstractService implements IStatsService
{

    use CacheTrait;

    /**
     * select distinct sofer, sum(distance) from tasks where vehicleNo<>'' group by sofer
     * or
     * select distinct vehicleNo, sum(distance) from tasks where vehicleNo<>'' group by vehicleNo
     * @param $command
     * @return TaskSearchCommand[]
     */
    public function findStatsByType($command)
    {
        $type = $command->getCriteria();
        $stats = array();
        $aggregatedResults = $this->getTaskRepository()->aggregateDistancePerCriteria($command);

        foreach ($aggregatedResults as $result) {
            $command = new StatsSearchCommand();
            array_push($stats, $command->setName($result[$type])->setDistance($result["distance"]));
        }

        return $stats;
    }


    /**
     * @param $command StatsSearchCommand
     * @return mixed
     */
    public function updateStatsByCriteria($command)
    {
        if (strcmp($command->getNewValue(), "STERS") == 0) {
            $command->setNewValue("");
        }
        $this->getTaskRepository()->updateDriverOrVehicleByCriteria($command);
    }
}