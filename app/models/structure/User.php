<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 11:10 AM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Entities\Structure;

use Illuminate\Auth\UserInterface;
use Mitch\LaravelDoctrine\Traits\Timestamps;
use Doctrine\ORM\Mapping as ORM;
use Mitch\LaravelDoctrine\Traits\SoftDeletes;
use Mitch\LaravelDoctrine\Traits\Authentication;
use Transp\Entities\Interf\AbstractEntity;
use Transp\Entities\EntityTraits\EntityID;
use Transp\Entities\EntityTraits\JSerialize;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends AbstractEntity implements UserInterface
{
    use Authentication;
    use EntityID;
    use Timestamps;
    use SoftDeletes;
    use JSerialize;

    /**
     * @ORM\Column(type="string", name="username", unique=true)
     */
    private $username;


    /**
     * @ORM\Column(type="string", name="email", nullable=true)
     */
    private $email;

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }
}