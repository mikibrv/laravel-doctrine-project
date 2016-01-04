<?php
/**
 * User: mcsere
 * Date: 10/31/14
 * Time: 5:58 PM
 * Contact: miki@softwareengineer.ro
 */

use Transp\Service\ICMSService;

final class Content
{

    static function get($key)
    {
        $value = self::getCMSService()->getCMSByKey($key);
        if (!isset($value) || $value == null) {
            return "";
        }
        return $value->getValue();
    }

    static function getArray($key)
    {
        $value = self::getCMSService()->getCMSByKey($key);
        if (!isset($value) || $value == null) {
            return array();
        }
        return explode(";", $value->getValue());
    }


    /**
     * @return ICMSService
     */
    private static function  getCMSService()
    {
        return App::make("Transp\Service\ICMSService");
    }

    private function __construct()
    {
    }
} 