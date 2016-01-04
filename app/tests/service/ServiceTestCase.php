<?php
/**
 * User: mcsere
 * Date: 9/1/14
 * Time: 5:48 PM
 * Contact: miki@softwareengineer.ro
 */

namespace test\service;


use App;
use Transp\Service\ICMSService;
use Transp\Service\IPageService;
use Transp\Service\ITaskService;

class ServiceTestCase extends \Illuminate\Foundation\Testing\TestCase
{

    /**
     * @var IPageService
     */
    protected $pageService;

    /**
     * @var ICMSService
     */
    protected $cmsService;


    /**
     * @var ITaskService
     */
    protected $taskService;

    protected function setUPServices()
    {
        $this->pageService = App::make("Transp\Service\PageService");
        $this->cmsService = App::make("Transp\Service\CMSService");
        $this->taskService = App::make("Transp\Service\TaskService");
    }

    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require __DIR__ . '/../../../bootstrap/start.php';
    }

} 