<?php
namespace Transp\Entities\Structure;

use Doctrine\ORM\Mapping AS ORM;
use Mitch\LaravelDoctrine\Traits\SoftDeletes;
use Mitch\LaravelDoctrine\Traits\Timestamps;
use Transp\Entities\Interf\AbstractEntity;
use Transp\Entities\EntityTraits\EntityID;
use Transp\Entities\EntityTraits\JSerialize;

/**
 * @ORM\Entity
 * @ORM\Table(name="lang", options={"collate"="utf8_general_ci", "charset"="utf8"})
 * @ORM\HasLifecycleCallbacks()
 */
class Lang extends AbstractEntity
{
    use EntityID;
    use SoftDeletes;
    use Timestamps;
    use JSerialize;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string")
     */
    private $label;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

}