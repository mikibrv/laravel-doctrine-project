<?php
/**
 * User: mcsere
 * Date: 10/29/14
 * Time: 4:47 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Service;


use Transp\Entities\Structure\Lang;
use Transp\Service\Interf\AbstractService;
use Transp\Service\Traits\CacheTrait;

interface ILangService
{
    /**
     * @return Lang
     */
    public function getCurrentLanguage();
}

class LangService extends AbstractService implements ILangService
{


}