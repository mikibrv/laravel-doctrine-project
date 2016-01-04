<?php
/**
 * Created by PhpStorm.
 * User: miki
 * Date: 14.04.2015
 * Time: 00:19
 */

namespace Transp\Controllers\Admin;


use HTML;
use Input;
use Transp\Controllers\Interf\BaseController;

class AutoCompleteController extends BaseController
{

    public function get($word)
    {
        $dbResults = $this->autoCompleteService->fetch(HTML::entities($word));
        $json = array();
        foreach ($dbResults as $row) {
            $inner = array("label" => $row->getWord(), "rank" => $row->getRank());
            array_push($json, $inner);
        }
        return json_encode($json);
    }


    public function deleteWord($word)
    {
        $this->autoCompleteService->delete(HTML::entities($word));
        return "OK";
    }


    public function upsertWord($word)
    {
        $this->autoCompleteService->upsertWord(HTML::entities($word));
        return "OK";
    }
}