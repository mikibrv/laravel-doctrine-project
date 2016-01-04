<?php

namespace Transp\Controllers\Interf;

use App;
use Illuminate\Routing\Controller;
use Request;
use Transp\Entities\enums\Layouts;
use Transp\Repositories\Structure\ILangRepository;
use Transp\Repositories\Structure\IPageRepository;
use View;


class BaseController extends Controller
{


    /**
     * @var \Transp\Service\IPageService
     */
    protected $pageService;

    /**
     * @var \Transp\Service\ICMSService
     */
    protected $cmsService;

    /**
     * @var \Transp\Service\ILangService
     */
    protected $langService;

    /**
     * @var IPageRepository
     */
    protected $pageRepository;

    /**
     * @var \Transp\Service\ITaskService
     */
    protected $taskService;

    /**
     * @var \Transp\Service\IAutoCompleteService
     */
    protected $autoCompleteService;


    /**
     * @var ILangRepository
     */
    protected $langRepository;

    public function __construct(\Transp\Service\IPageService $pageService,
                                \Transp\Service\ICMSService $cmsService,
                                \Transp\Service\ILangService $langService,
                                \Transp\Service\ITaskService $taskService,
                                \Transp\Service\IAutoCompleteService $autoCompleteService)
    {
        $this->pageService = $pageService;
        $this->cmsService = $cmsService;
        $this->langService = $langService;
        $this->taskService = $taskService;
        $this->autoCompleteService = $autoCompleteService;
        $this->pageRepository = App::make("Transp\Repositories\Structure\IPageRepository");
        $this->langRepository = App::make("Transp\Repositories\Structure\ILangRepository");
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void

    protected function setupLayout()
     * {
     * if (!is_null($this->layout)) {
     * $this->layout = View::make("layouts/" . $this->layout);
     * }
     * }
     */

    /**
     * @param $page
     * @return string
     */
    protected function getView($page)
    {
        return "pages." . \Transp\Entities\enums\Layouts::byDomain(Request::getHost()) . ".$page";
    }

    /**
     * @param $view
     * @param $model
     * @return $this
     */
    protected function renderView($view, $model)
    {
        return View::make(Layouts::getLayout(Layouts::byDomain(Request::getHost())))->with($model)
            ->nest("content", $this->getView($view), $model);
    }

}
