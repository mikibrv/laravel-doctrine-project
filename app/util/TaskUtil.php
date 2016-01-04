<?php
use Transp\Entities\Task;

/**
 * User: mcsere
 * Date: 12/8/14
 * Time: 11:52 AM
 * Contact: miki@softwareengineer.ro
 */
class TaskUtil
{

    public static $CURSA_LUNGA = "lung";
    public static $CURSA_SCURTA = "scurt";

    public static function generateFullTextTask(Task $task)
    {
        return $task->getClient() . " : " . $task->getTraseu() . " : "
        . $task->getSofer() . ":" . $task->getVehicleNo() . " : " . $task->getDataString();
    }

    public static function isValidCursa($tipCursa)
    {
        if (strcasecmp($tipCursa, self::$CURSA_LUNGA) == 0 || strcasecmp($tipCursa, self::$CURSA_SCURTA) == 0) {
            return true;
        }
        return false;
    }

} 