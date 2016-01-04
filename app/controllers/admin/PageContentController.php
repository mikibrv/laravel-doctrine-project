<?php
/**
 * User: mcsere
 * Date: 10/27/14
 * Time: 3:58 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Controllers\Admin;

use Exception;
use Input;
use Redirect;
use Response;
use Transp\Controllers\Interf\BaseController;
use Transp\Entities\Structure\CMS;
use View;

class PageContentController extends BaseController
{

    public function index()
    {
        $model = array();
        $model['menu'] = AdminMenuEnum::LEFT_MENU("content");
        $model['languageList'] = $this->pageService->getAllLanguages();
        return View::make('admin.pagecontent.index', $model);
    }

    public function getContentByLang($lang)
    {
        return Response::json($this->cmsService->getCMSForLanguage($lang));
    }

    public function addContent()
    {
        $title = Input::get("title");
        $key = Input::get("key");
        $value = Input::get("value");
        $lang = Input::get("lang");

        try {
            $cms = new CMS();
            $cms->setKey($key);
            $cms->setValue($value);
            $cms->setLabel($title);
            $cms->setLang($this->langRepository->findByCode($lang));
            $this->cmsService->addCMS($cms);
        } catch (Exception $exception) {
            // i really don't care
        }

        return Redirect::to('admin/site/continut');
    }

    public function updateContent()
    {
        $contentID = Input::get("id");
        $value = Input::get("value");
        if (isset($value) && isset($contentID)) {
            $this->cmsService->updateCMS($contentID, $value);
            return "true";
        } else {
            return "false";
        }
    }
} 