<?php
/**
 * User: mcsere
 * Date: 10/28/14
 * Time: 12:52 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Service;

use Config;
use Transp\Entities\Structure\CMS;
use Transp\Service\Interf\AbstractService;
use Transp\Service\traits\RepoTrait;

interface ICMSService
{

    /**
     * @param $language string ; ex: ro, en
     * @return CMS[]
     */
    public function getCMSForLanguage($language);

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function updateCMS($id, $value);

    /**
     * @param $key
     * @return CMS
     */
    public function getCMSByKey($key);

    /**
     * @param $key
     * @param $lang
     * @return CMS
     */
    public function getCMSByKeyAndLanguage($key, $lang);

    /**
     * @param CMS $cms
     * @return void
     */
    public function addCMS(CMS $cms);
}

class CMSService extends AbstractService implements ICMSService
{

    /**
     * @param $language
     * @return CMS[]
     */
    public function getCMSForLanguage($language)
    {
        $lang = $this->getLangRepository()->findByCode($language);
        if ($lang == null) {
            return null;
        }
        $cms = array();
        $defaultLanguage = $this->getLangRepository()->findByCode(Config::get("app.locale"));
        if ($defaultLanguage != null && !strcmp($lang->getCode(), $defaultLanguage->getCode()) == 0) {
            //default language should always be filled, damn it
            $cms = $this->getCmsRepository()->getCMSListWithDefault($lang, $defaultLanguage);
        } else {
            $cms = $this->getCmsRepository()->getCMSListByLang($lang);
        }
        return $cms;
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function updateCMS($id, $value)
    {
        $cms = $this->getCmsRepository()->find($id);
        if ($cms != null) {
            $cms->setValue($value);
            $this->getCmsRepository()->update($cms);
        }
    }

    /**
     * @param $key
     * @return CMS
     */
    public function getCMSByKey($key)
    {
        $currentLanguage = $this->getCurrentLanguage();
        $defaultLanguage = $this->getLangRepository()->findByCode(Config::get("app.locale"));
        if ($currentLanguage == null) {
            $currentLanguage = $defaultLanguage;
        }
        return $this->cache($key . $currentLanguage . $defaultLanguage, 1440, function ()
        use ($key, $currentLanguage, $defaultLanguage) {
            return $this->getCmsRepository()->getCMS($key, $currentLanguage, $defaultLanguage);
        });
    }

    /**
     * @param CMS $cms
     * @return void
     */
    public function addCMS(CMS $cms)
    {
        $this->getCmsRepository()->create($cms);
    }

    /**
     * @param $key
     * @param $lang
     * @return mixed
     */
    public function getCMSByKeyAndLanguage($key, $lang)
    {
        $currentLanguage = $this->getLangRepository()->findByCode($lang);
        $defaultLanguage = $this->getLangRepository()->findByCode(Config::get("app.locale"));
        if ($currentLanguage == null) {
            $currentLanguage = $defaultLanguage;
        }
        return $this->cache($key . $currentLanguage . $defaultLanguage, 1440, function ()
        use ($key, $currentLanguage, $defaultLanguage) {
            return $this->getCmsRepository()->getCMS($key, $currentLanguage, $defaultLanguage);
        });
    }
}