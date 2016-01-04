<?php
/**
 * User: mcsere
 * Date: 10/31/14
 * Time: 6:33 PM
 * Contact: miki@softwareengineer.ro
 */

namespace test\service;


use Transp\Entities\Task;

class TaskServiceTest extends ServiceTestCase
{

    public function testAll()
    {
        $this->setUPServices();
        for ($i = 0; $i < 100; $i++) {
            $this->createTasK($i);
        }

    }

    private function createTasK($i)
    {
        $task = new Task();
        $task->setBani("+100 RON");
        $task->setClient("PMVC");
        $task->setCursa("lung");
        $task->setDataString("15 decembrie 2014");
        $task->setDetalii("Detaliile sunt esenta");
        $task->setTraseu("BUC_OTP");
        $task->setDateTime(new \DateTime('+6 days'));
        $task->setSofer("TEST");
        $task->setFullTask(\TaskUtil::generateFullTextTask($task));
        $this->taskService->add($task);

        sleep(5);

        $task = new Task();
        $task->setBani("-100 RON");
        $task->setClient("SNCF");
        $task->setCursa("scurt");
        $task->setDataString("17 decembrie 2014");
        $task->setDetalii("Detaliile sunt esenta");
        $task->setTraseu("BCN - BCN");
        $task->setFullTask(\TaskUtil::generateFullTextTask($task));
        $task->setDateTime(new \DateTime('+ 8 days'));
        $task->setSofer("TEST-TEST");
        $this->taskService->add($task);
    }


}