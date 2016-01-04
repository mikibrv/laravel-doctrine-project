<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 3:56 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Repositories\Structure;


use Transp\Repositories\Interf\AbstractRepository;
use Transp\Repositories\Interf\IRepository;

interface IUserRepository extends IRepository
{

}

class UserRepository extends AbstractRepository implements IUserRepository
{

    private $entity = "Transp\Entities\Structure\User";

    protected function getEntity()
    {
        return $this->entity;
    }

}