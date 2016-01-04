<?php
/**
 * User: mcsere
 * Date: 8/29/14
 * Time: 11:53 AM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Repositories\Interf;


/**
 * Interface IRepository
 * @package repositories\interf
 */
interface IRepository
{

    /**
     * @param $entity
     * @return mixed
     */
    public function create($entity);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param $entity
     * @return mixed
     */
    public function update($entity);

    /**
     * @param $entity
     * @return mixed
     */
    public function delete($entity);

    /**
     * @param $lowerLimit
     * @param $superiorLimit
     * @param array $conditions
     * @param array $orderBy
     * @return mixed
     */
    public function all($lowerLimit, $superiorLimit, $conditions = array(), $orderBy = array());

    /**
     * @return  Integer
     */
    public function count();
} 