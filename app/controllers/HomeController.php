<?php

use Transp\Controllers\Interf\BaseController;
use Transp\Entities\enums\Domain;

class HomeController extends BaseController
{

    public function showIndex()
    {
        $model = array();
        return $this->renderView("index", $model);
    }
}