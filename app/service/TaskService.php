<?php
/**
 * User: mcsere
 * Date: 12/8/14
 * Time: 11:24 AM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Service;

use DateInterval;
use Transp\Commands\TaskSearchCommand;
use Transp\Entities\Task;
use Transp\Service\Interf\AbstractService;

interface ITaskService
{
    /**
     * @param Task $task
     * @return void
     */
    public function add($task);

    /**
     * @param TaskSearchCommand $command
     * @return array
     */
    public function fetch(TaskSearchCommand $command);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @return Task
     */
    public function findById($id);

}

class TaskService extends AbstractService implements ITaskService
{


    /**
     * @param Task $task
     * @return void
     */
    public function add($task)
    {

        if (!\TaskUtil::isValidCursa($task->getCursa())) {
            $task->setCursa(\TaskUtil::$CURSA_SCURTA);
        }
        $task->setFullTask(\TaskUtil::generateFullTextTask($task));
        $editHistory = $this->addFirstEdit();
        $task = $this->validateDistance($task);
        if ($task->getId() != null && is_numeric($task->getId())) {
            $existingTask = $this->getTaskRepository()->find($task->getId());
            $task->setEditHistory($editHistory . "|" . $existingTask->getEditHistory());
            $this->getTaskRepository()->update($task);
        } else {
            $task->setEditHistory($editHistory);
            $this->getTaskRepository()->create($task);
        }
    }

    /**
     * @param Task $task
     * @return Task
     */
    private function validateDistance($task)
    {
        if (!is_numeric($task->getDistance())) {
            $task->setDistance(0);
        }
        return $task;
    }

    private function addFirstEdit()
    {
        $editHistory = "";
        if (\Auth::user()) {
            $editHistory .= \Auth::user()->getUsername();
        }
        $editHistory .= "-" . date('Y-m-d H:i:s');
        return $editHistory;
    }


    public function fetch(TaskSearchCommand $command)
    {
        if ($command->getFilter() != null) {
            if (strlen($command->getFilter()) < 2) {
                $command->setFilter(null); //we don't search when lower than 2 chars.. wtf
            }
        }

        $dateDiff = 'P1D';
        if (strcmp($command->getTipCursa(), "scurt") == 0) {
            //for tip cursa scurt we also save the hours in the timestamp. no need to do -1 in search
            $dateDiff = 'P0D';
        }

        if ($command->getStartDate() != null) {
            $command->setDateStartDate($command->getStartDate()->sub(new DateInterval('P0D')));
        } else {
            $today = new \DateTime('now');
            $command->setDateStartDate($today->sub(new DateInterval($dateDiff)));
        }
        $tasksList = $this->getTaskRepository()->fetchFutureTasks($command);
        $total = $this->getTaskRepository()->fetchCountFutureTasks($command);

        $result = array();
        $result["recordsTotal"] = $total;
        $result["recordsFiltered"] = $total;
        $data = array();

        foreach ($tasksList as $task) {
            $haveWePushed = false;

            if ($command->getSplitDetails()) {

                $multiDetails = explode(";", $task->getDetalii());
                $count = sizeof($multiDetails);
                foreach ($multiDetails as $detail) {
                    if ($count > 1 && strlen($detail) > 0) {
                        $task->setBani("");
                        $task->setDetalii($detail);
                        if (str_contains($detail, " ")) {

                            $codBaniList = explode(" ", $detail);
                            foreach ($codBaniList as $codBani) {
                                if (is_numeric($codBani)) {
                                    $task->setBani($codBani);
                                }
                            }

                        }
                        $row = $this->createRow($task);
                        array_push($data, $row);
                        $haveWePushed = true;
                    }
                }


            }

            if (!$haveWePushed) {
                $row = $this->createRow($task);
                array_push($data, $row);
            }
        }
        $result["data"] = $data;
        return $result;
    }

    /**
     * @param Task $task
     * @return array
     */
    private function createRow(Task $task)
    {
        $row = array();
        array_push($row, $task->getId());
        array_push($row, $task->getDataString());
        array_push($row, $task->getOraText());
        array_push($row, $task->getClient());
        if ($task->getDistance() == 0 || $task->getDistance() == null) {
            array_push($row, $task->getTraseu());
        } else {
            array_push($row, $task->getTraseu() . " " . $task->getDistance() . "km");
        }

        //array_push($row, $task->getDateTime()->format("d/m/Y"));
        array_push($row, $task->getVehicle() . ": " . $task->getVehicleNo());
        array_push($row, $task->getSofer());
        array_push($row, $task->getBani());
        array_push($row, $task->getDetalii());
        return $row;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $task = $this->getTaskRepository()->find($id);
        if ($task != null) {
            $editHistory = \Auth::user()->getUsername() . "-" . date('Y-m-d H:i:s');
            $task->setEditHistory($editHistory . "|" . $task->getEditHistory());
            $this->getTaskRepository()->update($task);
            $this->getTaskRepository()->delete($task);
        }
    }

    /**
     * @param $id
     * @return Task
     */
    public function findById($id)
    {
        if (is_numeric($id) && $id > 0) {
            return $this->getTaskRepository()->find($id);
        }
    }
}