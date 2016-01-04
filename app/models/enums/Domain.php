<?php
/**
 * User: mcsere
 * Date: 9/2/14
 * Time: 11:37 AM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Entities\enums;


use Request;

abstract class Domain
{
    const TEST = "www.localhost/";
    const DOMAINEONE = "www.domain-one.org/";
    const ADMIN = "www.domain-one.ro/admin/";
    const DOMAINTWO = "www.domaine-two.ro/";

    static private $DOMAINS = array(self::TEST, self::ADMIN, self::DOMAINEONE, self::DOMAINTWO);

    //there will be one default layout / domain
    static function getLayout($domain)
    {
        if (self::is($domain)) {

        }
    }

    static function getDomain($url)
    {
        $result = self::TEST;
        foreach (self::$DOMAINS as $domain) {
            if (str_contains($url, $domain)) {
                $result = $domain;
            }
        }
        return $result;
    }

    static function hasSame($firstURL, $secondURL)
    {
        if (self::getDomain($firstURL) == self::getDomain($secondURL)) {
            return true;
        }
        return false;
    }

    static function current()
    {
        return self::getDomain(Request::url());
    }

    /**
     * Only public Domains
     * @return array
     */
    static function getDomainsArray()
    {
        return array(self::DOMAINEONE, self::DOMAINTWO);
    }

    static function is($domainToCheck)
    {
        foreach (self::$DOMAINS as $domain) {
            if (strcasecmp($domain, $domainToCheck) == 0) {
                return true;
            }
        }
        return false;
    }
} 