<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 2:10 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Entities\Interf;


/**
 * Class AbstractEntity
 * @package Transp\Entities\Interf
 */
abstract class AbstractEntity implements \JsonSerializable
{
    function __toString()
    {
        return json_encode($this, false);
    }

}