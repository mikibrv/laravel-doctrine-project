<?php
/**
 * User: mcsere
 * Date: 9/2/14
 * Time: 12:19 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Controllers;


use Transp\Controllers\Interf\BaseController;
use Transp\Entities\enums\Layouts;
use Transp\Entities\Structure\Page;
use View;

class CustomPageController extends BaseController
{

    public function index(Page $page)
    {
        return View::make(Layouts::getLayout($page->getLayout()))
            ->with("page", $page)
            ->nest("content", "pages.custom", array("page" => $page));
    }

} 