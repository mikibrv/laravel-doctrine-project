<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 2:11 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Entities\EntityTraits;

/**
 * Class EntityID
 * @package Transp\Entities\Interf
 * Contains Entity
 */
trait EntityID
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


}