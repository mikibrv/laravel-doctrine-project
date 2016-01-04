<?php
/**
 * Created by PhpStorm.
 * User: miki
 * Date: 14.04.2015
 * Time: 00:12
 */

namespace Transp\Entities;

use Doctrine\ORM\Mapping as ORM;
use Transp\Entities\EntityTraits\EntityID;
use Transp\Entities\EntityTraits\JSerialize;
use Transp\Entities\Interf\AbstractEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="auto_complete",  uniqueConstraints={@ORM\UniqueConstraint(name="word_unique",columns={"word"})}, options={"collate"="utf8_general_ci", "charset"="utf8"})
 * @ORM\HasLifecycleCallbacks()
 */
class AutoComplete extends AbstractEntity
{

    use EntityID;
    use JSerialize;


    /**
     * @ORM\Column
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    private $word;


    /**
     * @ORM\Column(type="integer",options={"default" = 0})
     */
    private $rank = 0;

    /**
     * @return mixed
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @param mixed $word
     */
    public function setWord($word)
    {
        $this->word = $word;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param mixed $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }


}