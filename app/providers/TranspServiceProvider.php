<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 4:18 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Providers;


use Illuminate\Support\ServiceProvider;
use Transp\Service\AutoCompleteService;
use Transp\Service\CMSService;
use Transp\Service\LangService;
use Transp\Service\PageService;
use Transp\Service\StatsService;
use Transp\Service\TaskService;

class TranspServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("Transp\Service\IPageService", function () {
            return new PageService();
        });
        $this->app->bind("Transp\Service\ICMSService", function () {
            return new CMSService();
        });
        $this->app->bind("Transp\Service\ILangService", function () {
            return new LangService();
        });
        $this->app->bind("Transp\Service\ITaskService", function () {
            return new TaskService();
        });
        $this->app->bind("Transp\Service\IAutoCompleteService", function () {
            return new AutoCompleteService();
        });
        $this->app->bind("Transp\Service\IStatsService", function () {
            return new StatsService();
        });
    }
}