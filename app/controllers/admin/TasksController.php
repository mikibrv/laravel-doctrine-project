<?php
/**
 * User: mcsere
 * Date: 11/28/14
 * Time: 6:41 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Controllers\Admin;


use HTML;
use Input;
use Transp\Commands\TaskSearchCommand;
use Transp\Controllers\Interf\BaseController;
use Transp\Entities\enums\LangCodes;
use Transp\Entities\Structure\CMS;
use Transp\Entities\Task;
use View;

class TasksController extends BaseController
{

    public function index()
    {
        return View::make('admin.new.index', $this->getModelForForm());
    }

    private function getModelForForm()
    {
        $model = array();
        $model['menu'] = AdminMenuEnum::LEFT_MENU("home");

        $defaultCustomersCMS = $this->cmsService->getCMSByKeyAndLanguage(AdminCMSConstants::CUSTOMERS, LangCodes::RO);
        $defaultRoutesCMS = $this->cmsService->getCMSByKeyAndLanguage(AdminCMSConstants::ROUTES, LangCodes::RO);
        $defaultDriversCMS = $this->cmsService->getCMSByKeyAndLanguage(AdminCMSConstants::DRIVERS, LangCodes::RO);
        $defaultVehiclesCMS = $this->cmsService->getCMSByKeyAndLanguage(AdminCMSConstants::VEHICLES, LangCodes::RO);


        //comma separated values in CMS
        $this->addDefaultCMSValuesToModel($model, "defaultCustomers", $defaultCustomersCMS);

        $this->addDefaultCMSValuesToModel($model, "defaultDrivers", $defaultDriversCMS);

        $this->addDefaultCMSValuesToModel($model, "defaultRoutes", $defaultRoutesCMS);

        $this->addDefaultCMSValuesToModel($model, "defaultVehicles", $defaultVehiclesCMS);
        //make sure if something crashes it does not crash everything

        return $model;
    }

    /**
     * @param $model
     * @param $key
     * @param CMS $cmsEntity
     */
    private function addDefaultCMSValuesToModel(&$model, $key, $cmsEntity)
    {
        $model[$key] = array();
        try {
            if ($cmsEntity != null) {
                $model[$key] = explode(",", $cmsEntity->getValue());
            }
        } catch (\Exception $exception) {
        }
    }


    public function newTask()
    {
        $task = $this->getTaskInfoFromInput();
        $this->taskService->add($task);
    }

    private function getTaskInfoFromInput()
    {
        $task = new Task();
        $input = Input::get("input");

        if (isset($input['id'])) {
            $task->setId(HTML::entities($input["id"]));
        }
        if (isset($input['client'])) {
            $task->setClient(HTML::entities(trim($input["client"])));
        }
        if (isset($input['traseu'])) {
            $task->setTraseu(HTML::entities(trim($input["traseu"])));
        }
        if (isset($input['detalii'])) {
            $task->setDetalii(HTML::entities(trim($input["detalii"])));
        }
        if (isset($input['vehicle'])) {
            $task->setVehicle(HTML::entities($input["vehicle"]));
        }
        $task->setCursa(HTML::entities($input["cursa"]));
        $task->setSofer(HTML::entities($input["sofer"]));
        $task->setBani(HTML::entities($input["bani"]));
        $task->setDataString(HTML::entities($input["dataText"]));
        $task->setOraText(HTML::entities($input["ora"]));
        $task->setDistance(HTML::entities($input["distance"]));
        $task->setVehicleNo(HTML::entities($input["vehicleNo"]));

        $task->setSofer(trim($task->getSofer()));
        $task->setBani(trim($task->getBani()));
        $task->setVehicleNo(trim($task->getVehicleNo()));


        $hourTransformed = 60; //1 minut is nice for the long ones
        if (strcmp($task->getCursa(), "scurt") == 0) {
            //numai pt cele scurte
            try {
                if (strlen($task->getOraText()) > 0) {
                    $hourSplitted = explode(':', $task->getOraText());
                    $hourTransformed = $hourSplitted[0] * 3600; //add the hours //all in seconds
                    $hourTransformed += $hourSplitted[1] * 60; // add the minutes
                }

            } catch (\Exception $e) {
                //can't afford an error here
            }
        }

        $date = new \DateTime();
        $date->setTimestamp((HTML::entities($input["data"]) / 1000) + $hourTransformed);
        $task->setDateTime($date);
        return $task;
    }


    public function fetch()
    {
        $start = Input::get("start");
        $length = Input::get("length");
        $searchArray = Input::get("search");


        $startDate = Input::get("startDate");
        $endDate = Input::get("endDate");

        $search = "";
        if (isset($searchArray)) {
            $search = $searchArray["value"];
        }

        $command = new TaskSearchCommand();
        $command->setFilter($search);
        $command->setLowerLimit($start);
        $command->setNoResults($length);
        $command->setStartDate($startDate);
        $command->setEndDate($endDate);
        $command->setTipCursa(Input::get("tipCursa"));

        if (strlen(Input::get("splitDetails")) > 0) {
            $command->setSplitDetails(true);
        }
        return json_encode($this->taskService->fetch($command), 0);
    }


    public function delete($id)
    {
        $this->taskService->delete($id);
        return "OK";
    }

    public function edit($id)
    {
        $model = $this->getModelForForm();
        if (is_numeric($id) && $id > 0) {
            $task = $this->taskService->findById($id);
            if ($task != null) {
                $model['currentTask'] = $task;
            } else {
                return "404";
            }
        }
        return View::make('admin.new.index', $model);
    }

} 