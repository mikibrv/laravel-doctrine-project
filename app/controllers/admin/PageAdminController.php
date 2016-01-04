<?php
/**
 * User: mcsere
 * Date: 9/4/14
 * Time: 10:10 AM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Controllers\Admin;


use Input;
use Response;
use Transp\Controllers\Interf\BaseController;
use Transp\Entities\enums\Domain;
use Transp\Entities\enums\Layouts;
use Transp\Entities\Structure\Page;
use View;

class PageAdminController extends BaseController
{

    public function index()
    {
        $model = array();
        $model['menu'] = AdminMenuEnum::LEFT_MENU("pages");
        $model['domains'] = Domain::getDomainsArray();
        $model['languageList'] = $this->pageService->getAllLanguages();
        return View::make('admin.pageadmin.index', $model);
    }

    public function getPagesByLang($lang)
    {
        return Response::json($this->pageService->getLightPagesForLanguage($lang, 0, 200));
    }

    /**
     * Returns the form for a new page / edit existing page if pageId != null;
     * @param null $pageId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getForm($pageId = null)
    {
        $model = array();
        if ($pageId != null) {
            $page = $this->pageRepository->find($pageId);
            if ($page != null) {
                if (Input::get("isCopy") != null && strcasecmp(Input::get("isCopy"), "true") == 0) {
                    $page->setId(null); //in case we want to copy a page :)
                } else {
                    $model['pageId'] = $pageId;
                }
                $model['page'] = $page;
            } else {
                $page = new Page();
                $model['page'] = $page;
            }
        } else {
            $page = new Page();
            $model['page'] = $page;
        }
        return View::make('admin.pageadmin.form', $model);
    }

    public function getSlugByLangAndTitle($domain, $lang, $title)
    {
        //first check if slug exists
        if (Input::get("slug") != null) {
            $title = Input::get("slug");
        }

        if (str_contains($title, "/")) {
            $titleExploded = explode("/", $title);
            $title = "";
            foreach ($titleExploded as $titleFragment) {
                if ((!strcasecmp($titleFragment, $lang) == 0) && (strlen($titleFragment) > 0)) {
                    $title .= \Str::slug($titleFragment) . "/"; //lang will be added later
                }
            }
            $title = substr($title, 0, -1);
        } else {
            $title = \Str::slug($title);
        }

        $slug = $lang . "/" . $title;
        $domain .= "/";
        $page = $this->pageService->findPageBySlugAndDomain($slug, $domain);
        if ($page == null) {
            return Response::json($slug);
        } else {
            //add a date or something to the slug;
            $slug = $lang . "/" . date("d/m/Y") . "/" . $title;
            //and check again
            $page = $this->pageService->findPageBySlugAndDomain($slug, $domain);
            if ($page == null) {
                return Response::json($slug);
            } else { //in case it's actually hard for him to get a valid slug
                for ($i = 100; $i < 10000; $i += 100) {
                    $slug = $lang . "/" . date("d/m/Y") . "/" . $i . "/" . \Str::slug($title);
                    $page = $this->pageService->findPageBySlugAndDomain($slug, $domain);
                    if ($page == null) {
                        return Response::json($slug);
                    }
                }

            }
        }
    }

    public function pictureBrowser()
    {
        return View::make('admin.pageadmin.image-browser');
    }

    public function upsertPage()
    {
        $pageId = Input::get("pageid");
        if ($pageId != null && strlen(trim($pageId)) > 0) {
            $page = $this->pageRepository->find($pageId);
        }
        if (!isset($page) || $page == null) {
            $page = new Page();
        }
        $langCode = Input::get("lang");

        $lang = $this->langRepository->findByCode($langCode);
        if ($lang != null) {
            $page->setLang($lang);
        }

        $page->setSlug(trim(Input::get("pageurl")));
        $page->setContent(trim(Input::get("content")));
        $page->setTitle(Input::get("title"));
        $page->setKeywords(Input::get("keywords"));
        $page->setDomain(trim(Input::get("domain")));
        $page->setDescription(Input::get("pagedescription"));
        $page->setLayout(Layouts::byDomain($page->getDomain()));


        if ($page->getId() == null) {
            $this->pageRepository->create($page);
        } else {
            $this->pageRepository->update($page);
        }

        return \Redirect::to("/admin/site/pagini-web");
    }

    public function deletePage($pageId)
    {
        $page = $this->pageRepository->find($pageId);
        if ($page != null) {
            $page->setSlug("" . time()); //clear slug, so we can reuse it;
            $this->pageRepository->update($page);
            $this->pageRepository->delete($page);
            return "true";
        }
        return "false";
    }

} 