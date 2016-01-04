<?php
/**
 * User: mcsere
 * Date: 10/29/14
 * Time: 4:56 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Service\Traits;


use Transp\Entities\Structure\Lang;

trait LangTrait
{
    /**
     * @return RepoTrait
     */
    protected abstract function getRepoTrait();

    /**
     * @return CacheTrait
     */
    protected abstract function getCacheTrait();

    /**
     * @return Lang
     */
    public function getCurrentLanguage()
    {
        /**
         * @var Lang[] $languagesList
         */
        $languagesList = $this->getCacheTrait()->cache("allLanguages", 100,
            function () {
                return $this->getRepoTrait()->getLangRepository()->all(0, 100);
            });

        $requestSegmentsList = \Request::segments();
        foreach ($requestSegmentsList as $segment) {
            //usually it should be the first segment, but we cannot guarantee
            foreach ($languagesList as $language) {
                if (strcmp($segment, $language->getCode()) == 0) {
                    return $language;
                }
            }
        }
        return null;
    }

} 