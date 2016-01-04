<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 12:06 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Providers;

use Illuminate\Support\ServiceProvider;
use Transp\repositories\AutoCompleteRepository;
use Transp\Repositories\Structure\CMSRepository;
use Transp\Repositories\Structure\LangRepository;
use Transp\Repositories\Structure\PageRepository;
use Transp\Repositories\Structure\UserRepository;
use Transp\Repositories\TaskRepository;


class RepositoryProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Transp\Repositories\Structure\ILangRepository', function () {
            return new LangRepository();
        });

        $this->app->bind('Transp\Repositories\Structure\IUserRepository', function () {
            return new UserRepository();
        });

        $this->app->bind('Transp\Repositories\Structure\ICMSRepository', function () {
            return new CMSRepository();
        });

        $this->app->bind('Transp\Repositories\Structure\IPageRepository', function () {
            return new PageRepository();
        });


        $this->app->bind('Transp\Repositories\ITaskRepository', function () {
            return new TaskRepository();
        });

        $this->app->bind('Transp\Repositories\IAutoCompleteRepository', function () {
            return new AutoCompleteRepository();
        });
    }
}