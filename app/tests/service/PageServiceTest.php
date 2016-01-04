<?php
/**
 * User: mcsere
 * Date: 9/1/14
 * Time: 5:49 PM
 * Contact: miki@softwareengineer.ro
 */

namespace test\service;


use Transp\Entities\enums\Domain;
use Transp\Entities\enums\Layouts;
use Transp\Entities\Structure\Page;
use Transp\Util\PageRenderer;

class PageServiceTest extends ServiceTestCase
{


    public function testGetBySlug()
    {
        $this->setUPServices();
        $expectedPage = $this->findOnePage();
        if ($expectedPage) {
            //if we actually have a page, let's search for the same page by slug
            $page = $this->pageService->findPageBySlugAndDomain($expectedPage->getSlug(), $expectedPage->getDomain());
            $this->assertEquals($expectedPage, $page);
        }
    }


    /**
     * @return null|Page
     */
    private function findOnePage()
    {
        $allLangs = $this->pageService->getAllLanguages();
        foreach ($allLangs as $lang) {
            $page = $this->pageService->getLightPagesForLanguage($lang->getCode(), 0, 1);
            if (sizeof($page) > 0) {
                return $page[0];
            }
        }
        return null;
    }


}