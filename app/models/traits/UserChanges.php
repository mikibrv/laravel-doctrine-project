<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 11:33 AM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Entities\EntityTraits;

use Doctrine\ORM\Mapping AS ORM;

/**
 * Class UserChanges
 * @package entities\traits
 * TODO: Still designing this;
 */
trait UserChanges
{

    /**
     * @ORM\Column(type="json_array", name="updated_by")
     */
    private $updatedBy;

    /**
     * @param mixed $updatedBy
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }


}