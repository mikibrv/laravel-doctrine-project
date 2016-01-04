<?php
/**
 * User: mcsere
 * Date: 10/31/14
 * Time: 5:00 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Service\Traits;


use Cache;

trait CacheTrait
{

    /**
     * @param $key
     * @param $time
     * @param $method
     * @return mixed
     */
    public function cache($key, $time, \Closure $method)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        } else {
            $result = $method();
            if (isset($result) && $result != null) {
                Cache::put($key, $result, $time);
                return $result;
            }
        }
    }

} 