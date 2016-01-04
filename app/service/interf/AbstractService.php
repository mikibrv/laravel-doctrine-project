<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 4:20 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Service\Interf;

use Transp\Service\Traits\CacheTrait;
use Transp\Service\Traits\LangTrait;
use Transp\Service\Traits\RepoTrait;

abstract class AbstractService
{
    use LangTrait, RepoTrait, CacheTrait;

    function __construct()
    {

    }

    /**
     * @return RepoTrait
     */
    protected function getRepoTrait()
    {
        return $this;
    }

    /**
     * @return CacheTrait
     */
    protected function getCacheTrait()
    {
        return $this;
    }

}