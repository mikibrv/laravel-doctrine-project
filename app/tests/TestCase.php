<?php
namespace Test;

use App;
use Transp\Repositories\Structure\ICMSRepository;
use Transp\Repositories\Structure\ILangRepository;
use Transp\Repositories\Structure\IPageRepository;
use Transp\Repositories\Structure\IUserRepository;

class TestCase extends \Illuminate\Foundation\Testing\TestCase {


    /**
     * @var ILangRepository
     */
    protected $langRepository;
    /**
     * @var IUserRepository
     */
    protected $userRepository;
    /**
     * @var ICMSRepository
     */
    protected $cmsRepository;
    /**
     * @var IPageRepository
     */
    protected $pageRepository;

    /*
     * @var ITaskRepository
     */
    protected $taskRepository;

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

    protected  function setUPRepositories(){
        /**
         * get repositories from IoC.
         */
        $this->langRepository = App::make("Transp\Repositories\Structure\ILangRepository");
        $this->cmsRepository = App::make("Transp\Repositories\Structure\ICMSRepository");
        $this->userRepository = App::make("Transp\Repositories\Structure\IUserRepository");
        $this->pageRepository = App::make("Transp\Repositories\Structure\IPageRepository");
        $this->taskRepository = App::make("Transp\Repositories\ITaskRepository");
    }

}
