<?php
/**
 * User: mcsere
 * Date: 10/29/14
 * Time: 2:24 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Test\Entities;


use Test\TestCase;
use Transp\Entities\Structure\CMS;
use Transp\Entities\Structure\Lang;

class CMSDataTest extends TestCase
{
    public function testCRUDCMS()
    {
        $this->setUPRepositories();
        $english = $this->langRepository->findByCode("en");
        if (!$english) {
            return;
        }
        $this->removeIfFound($english);
        $cmsElement = new CMS();
        $cmsElement->setKey("test");
        $cmsElement->setLabel("test");
        $cmsElement->setLang($english);
        $cmsElement->setValue("test");
        $this->cmsRepository->create($cmsElement);

        $this->assertTrue($this->removeIfFound($english));
    }

    /**
     * @param Lang $english
     * @return bool
     */
    private function removeIfFound(Lang $english)
    {
        $cmsElement = $this->cmsRepository->getCMS("test", $english, $english);
        if ($cmsElement) {
            $this->cmsRepository->delete($cmsElement);
            return true;
        } else {
            return false;
        }
    }

} 