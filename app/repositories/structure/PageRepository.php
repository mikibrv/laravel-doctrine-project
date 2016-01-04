<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 12:07 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Repositories\Structure;

use Transp\Entities\Structure\Page;
use Transp\Repositories\Interf\AbstractRepository;
use Transp\Repositories\Interf\IRepository;

interface IPageRepository extends IRepository
{
    /**
     * @param $slug
     * @return Page[]
     */
    public function findPagesBySlug($slug);

    /**
     * @param $lowerLimit
     * @param $superiorLimit
     * @param array $conditions
     * @param array $orderBy
     * @return Page[]
     */
    public function all($lowerLimit, $superiorLimit, $conditions = array(), $orderBy = array());


}

class PageRepository extends AbstractRepository implements IPageRepository
{

    private $entity = "Transp\Entities\Structure\Page";

    protected function getEntity()
    {
        return $this->entity;
    }

    public function findPagesBySlug($slug)
    {
        return $this->entityManager->getRepository($this->getEntity())
            ->findBy(array("slug" => $slug));
    }
}