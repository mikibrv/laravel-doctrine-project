<?php
/**
 * Created by PhpStorm.
 * User: miki
 * Date: 01.01.2016
 * Time: 17:53
 */

namespace Transp\Controllers\Admin;


use Controller;
use Input;
use Response;
use Transp\Commands\StatsSearchCommand;
use View;

class StatsPageController extends Controller
{


    /**
     * @var \Transp\Service\IStatsService
     */
    protected $statsService;

    /**
     * StatsPageController constructor.
     * @param \Transp\Service\IStatsService $statsService
     */
    public function __construct(\Transp\Service\IStatsService $statsService)
    {
        $this->statsService = $statsService;
    }


    public function index()
    {
        $model = array();
        $model['menu'] = AdminMenuEnum::LEFT_MENU("stats");
        return View::make('admin.stats.index', $model);
    }

    public function drivers()
    {
        return Response::json($this->statsService->findStatsByType(
            $this->getCommandFromInput()->setCriteria("sofer")
        ), 200);
    }

    public function vehicles()
    {
        return Response::json($this->statsService->findStatsByType(
            $this->getCommandFromInput()->setCriteria("vehicleNo")
        ), 200);
    }

    /**
     * @return StatsSearchCommand
     */
    public function getCommandFromInput()
    {
        $command = new StatsSearchCommand();
        $command->setStartDate(Input::get("startDate"));
        $command->setEndDate(Input::get("endDate"));
        return $command;
    }

    public function updateDrivers($old, $new)
    {
        $new = trim($new);
        $command = new StatsSearchCommand();
        $this->statsService->updateStatsByCriteria(
            $command->setCriteria("sofer")
                ->setOldValue($old)
                ->setNewValue($new));
        return Response::json("ok", 200);
    }

    public function updateVehicles($old, $new)
    {
        $new = trim($new);
        $command = new StatsSearchCommand();
        $this->statsService->updateStatsByCriteria(
            $command->setCriteria("vehicleNo")
                ->setOldValue($old)
                ->setNewValue($new));
        return Response::json("ok", 200);
    }
}