<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 4:20 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Service;


use Request;
use Transp\Entities\enums\Domain;
use Transp\Entities\Structure\Lang;
use Transp\Entities\Structure\Page;
use Transp\Service\Interf\AbstractService;

interface IPageService
{
    /**
     * @return Lang[]
     */
    public function getAllLanguages();

    /**
     * @param $slug
     * @param $domain Domain. is nullable If domain == null use current
     * @return Page
     */
    public function findPageBySlugAndDomain($slug, $domain = NULL);

    /**
     * Removes content field from pages.
     * @param string $language
     * @param $start
     * @param $end
     * @return Page[]
     */
    public function getLightPagesForLanguage($language, $start, $end);
}

class PageService extends AbstractService implements IPageService
{
    public function getAllLanguages()
    {
        return $this->getLangRepository()->all(0, 1000);
    }

    public function findPageBySlugAndDomain($slug, $domain = NULL)
    {
        if ($domain == null) {
            $domain = Domain::current();
        }
        $pageList = $this->getPageRepository()->findPagesBySlug($slug);
        if ($pageList != null) {
            foreach ($pageList as $page) {
                if (Domain::hasSame($page->getUrl(), Request::url())) {
                    return $page;
                }
            }
        }
        return null;
    }

    /**
     * Removes content field from pages.
     * @param $language
     * @param $start
     * @param $end
     * @return Page[]
     */
    public function getLightPagesForLanguage($language, $start, $end)
    {
        $lang = $this->getLangRepository()->findByCode($language);
        if ($lang == null) {
            return null;
        }
        $pages = $this->getPageRepository()->all($start, $end, array("lang" => $lang->getId()));
        foreach ($pages as $page) {
            $page->setContent("");
        }
        return $pages;
    }
}