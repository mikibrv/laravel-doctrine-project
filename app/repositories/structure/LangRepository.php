<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 12:07 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Repositories\Structure;


use Transp\Entities\Structure\Lang;
use Transp\Repositories\Interf\AbstractRepository;
use Transp\Repositories\Interf\IRepository;

interface ILangRepository extends IRepository
{
    /**
     * @param $code
     * @return Lang
     */
    public function findByCode($code);

}

class LangRepository extends AbstractRepository implements ILangRepository
{

    private $entity = "Transp\Entities\Structure\Lang";

    protected function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param $code
     * @return Lang
     */
    public function findByCode($code)
    {
        return $this->entityManager->getRepository($this->getEntity())->findOneBy(array("code" => $code));
    }
}