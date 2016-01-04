<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 3:28 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Entities\EntityTraits;


trait JSerialize
{

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
} 