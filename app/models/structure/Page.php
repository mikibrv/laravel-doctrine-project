<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 10:31 AM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Entities\Structure;

use Mitch\LaravelDoctrine\Traits\SoftDeletes;
use Mitch\LaravelDoctrine\Traits\Timestamps;
use Doctrine\ORM\Mapping as ORM;
use Transp\Entities\enums\Domain;
use Transp\Entities\enums\Layouts;
use Transp\Entities\Interf\AbstractEntity;
use Transp\Entities\EntityTraits\EntityID;
use Transp\Entities\EntityTraits\JSerialize;
use Transp\Service\Exceptions\InvalidDomainException;

/**
 * @ORM\Entity
 * @ORM\Table(name="page",uniqueConstraints={@ORM\UniqueConstraint(name="url", columns={"domain", "slug"})} ,options={"collate"="utf8_general_ci", "charset"="utf8"})
 * @ORM\HasLifecycleCallbacks()
 */
class Page extends AbstractEntity
{
    use EntityID;
    use SoftDeletes;
    use Timestamps;
    use JSerialize;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

    /**
     * It must be unique in combination with slug.
     * @ORM\Column(type="string", length=30)
     */
    private $domain;

    /**
     * @ORM\Column(type="string", nullable=true, length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string", nullable=true,  length=200)
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=true,  length=200)
     */
    private $keywords;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", nullable=false,  length=30)
     */
    private $layout = Layouts::DEFAULT_LAYOUT;

    /**
     * @ORM\ManyToOne(targetEntity="Lang")
     * @ORM\JoinColumn(name="lang_fk", nullable=false ,  referencedColumnName="id")
     * @var Lang
     */
    private $lang;

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $domain
     * @throws \Transp\Service\Exceptions\InvalidDomainException
     */
    public function setDomain($domain)
    {
        if (Domain::is($domain)) {
            $this->domain = $domain;
        } else {
            throw new InvalidDomainException;
        }
    }

    /**
     * @return mixed
     */
    public function getDomain()
    {
        return $this->domain;
    }


    /**
     * @param mixed $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return mixed
     */
    public function getKeywords()
    {
        return $this->keywords;
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
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * @return mixed
     */
    public function getLayout()
    {
        return $this->layout;
    }

    public function getURL()
    {
        return $this->domain . $this->slug;
    }


}