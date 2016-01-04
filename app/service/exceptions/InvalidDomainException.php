<?php
/**
 * User: mcsere
 * Date: 9/4/14
 * Time: 10:58 AM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Service\Exceptions;


use Lang;

class InvalidDomainException extends \Exception
{
    function __toString()
    {
        return Lang::get("alerts.invalid.domain");
    }
} 