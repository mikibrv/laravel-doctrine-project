<?php
/**
 * User: mcsere
 * Date: 9/2/14
 * Time: 12:24 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Util;


use App;
use Str;
use Transp\Entities\enums\Domain;
use Transp\Entities\Structure\Page;

class PageRenderer
{

    /**
     * @return Page
     */
    static function findCurrentPage()
    {
        $pageService = App::make("Transp\Service\IPageService");

        $domain = Domain::current();
        $slug = \Request::path();
        if (strlen($slug) > 1) {
            return $pageService->findPageBySlugAndDomain($slug, $domain);
        }
        return null;
    }

    /**
     * updates input Page with a slug
     * @param Page $page
     */
    static function updateSlug(Page $page)
    {
        $lang = $page->getLang();
        $prefix = "";
        if ($lang != null && $lang) {
            $prefix = $lang->getCode() . "/";
        }
        $page->setSlug($prefix . Str::slug($page->getTitle()));
    }

} 