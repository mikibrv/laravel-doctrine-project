<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 10:16 AM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Entities\Structure;

use Doctrine\ORM\Mapping as ORM;
use Mitch\LaravelDoctrine\Traits\Timestamps;
use Transp\Entities\Interf\AbstractEntity;
use Transp\Entities\EntityTraits\EntityID;
use Transp\Entities\EntityTraits\JSerialize;

/**
 * @ORM\Entity
 * @ORM\Table(name="cms", uniqueConstraints={@ORM\UniqueConstraint(name="cms_lang", columns={"cms_key", "lang_fk"})}, options={"collate"="utf8_general_ci", "charset"="utf8"}, )
 * @ORM\HasLifecycleCallbacks()
 */
class CMS extends AbstractEntity
{
    use EntityID;
    use Timestamps;
    use JSerialize;

    /**
     * @ORM\Column(type="string", name="cms_key")
     */
    private $key;


    /**
     * @ORM\Column(type="text", nullable=true ,name="value")
     */
    private $value;


    /**
     * @var string
     */
    private $defaultValue;


    /**
     * @ORM\Column(type="integer",  nullable = true ,name="list_id")
     */
    private $listId;


    /**
     * @ORM\Column(type="string", name="label")
     */
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity="Lang")
     * @ORM\JoinColumn(name="lang_fk", referencedColumnName="id")
     * @var Lang
     */
    private $lang;


    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param \Transp\Entities\Structure\Lang $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /**
     * @return \Transp\Entities\Structure\Lang
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param mixed $listId
     */
    public function setListId($listId)
    {
        $this->listId = $listId;
    }

    /**
     * @return mixed
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
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

    /**
     * @param string $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }


}