<?php
/**
 * Created by PhpStorm.
 * User: Miki
 * Date: 8/30/14
 * Time: 11:33 AM
 */

namespace Transp\Entities\enums;


abstract class Layouts
{
    const DOMAINEONE = "rent";
    const TRANSP = "transp";
    const ADMIN = "admin";
    const DEFAULT_LAYOUT = "rent";

    private static $DOMAIN_LAYOUTS = array(Domain::DOMAINEONE => Layouts::DOMAINEONE, Domain::DOMAINTWO => Layouts::TRANSP);

    public static function getLayout($layout)
    {
        return "layouts." . $layout;
    }

    public static function byDomain($domain)
    {
        if (Domain::is($domain)) {
            return (self::$DOMAIN_LAYOUTS[$domain]);
        }
        return self::DEFAULT_LAYOUT;
    }
} 