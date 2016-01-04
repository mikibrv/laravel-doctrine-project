<?php
/**
 * User: mcsere
 * Date: 9/2/14
 * Time: 4:32 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Controllers\Admin;


use Cache;
use Transp\Controllers\Interf\BaseController;
use View;

class AdminController extends BaseController
{

    public function index()
    {
        $model = array();
        $model['menu'] = AdminMenuEnum::LEFT_MENU("home");
        return View::make('admin.index', $model);
    }

    public function flushCache()
    {
        Cache::flush();
        return "true";
    }

}