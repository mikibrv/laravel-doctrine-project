<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 11:46 AM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Repositories\Interf;

use Doctrine\ORM\EntityManagerInterface;
use App;

abstract class AbstractRepository implements IRepository
{

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    function __construct()
    {
        $this->entityManager = App::make('Doctrine\ORM\EntityManagerInterface');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->entityManager->find($this->getEntity(), $id);
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function create($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function update($entity)
    {
        $this->entityManager->merge($entity);
        $this->entityManager->flush();
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function delete($entity)
    {
        $entity = $this->entityManager->merge($entity);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * @param $lowerLimit
     * @param $superiorLimit
     * @param array $conditions
     * @param array $orderby
     * @return array|mixed
     */
    public function all($lowerLimit, $superiorLimit, $conditions = array(), $orderby = array())
    {
        return $this->entityManager->getRepository($this->getEntity())
            ->findBy($conditions, $orderby, $superiorLimit - $lowerLimit, $lowerLimit);
    }

    /**
     * @return  Integer
     */
    public function count()
    {
        return $this->entityManager
            ->createQuery("SELECT COUNT('e') FROM " . $this->getEntity() . " e")->getSingleScalarResult();
    }

    protected abstract function getEntity();
} 