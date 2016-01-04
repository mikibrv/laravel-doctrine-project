<?php
/**
 * User: mcsere
 * Date: 12/8/14
 * Time: 11:17 AM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Repositories;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Types\Type;
use Transp\Commands\AbstractTaskSearchCommand;
use Transp\Commands\StatsSearchCommand;
use Transp\Commands\TaskSearchCommand;
use Transp\Entities\Task;
use Transp\Repositories\Interf\AbstractRepository;
use Transp\Repositories\Interf\IRepository;

interface ITaskRepository extends IRepository
{
    /**
     * @param $lowerLimit
     * @param $superiorLimit
     * @param array $conditions
     * @param array $orderBy
     * @return Task[]
     */
    public function all($lowerLimit, $superiorLimit, $conditions = array(), $orderBy = array());

    /**
     * @param TaskSearchCommand $command
     * @return Task[]
     */
    public function fetchFutureTasks(TaskSearchCommand $command);

    /**
     * @param TaskSearchCommand $command
     * @return int
     */
    public function fetchCountFutureTasks(TaskSearchCommand $command);


    /**
     * @param StatsSearchCommand $command
     * @return array
     */
    public function aggregateDistancePerCriteria($command);

    /**
     * @param $command StatsSearchCommand
     * @return mixed
     */
    public function updateDriverOrVehicleByCriteria($command);

}

class TaskRepository extends AbstractRepository implements ITaskRepository
{

    private $entity = "Transp\Entities\Task";

    protected function getEntity()
    {
        return $this->entity;
    }

    public function fetchFutureTasks(TaskSearchCommand $command)
    {
        $em = $this->entityManager;
        $qb = $em->createQueryBuilder();

        $qb->select(array('t'))
            ->from($this->entity, 't')
            ->where(
                "1=1")->orderBy('t.dateTime', 'ASC')
            ->setFirstResult($command->getLowerLimit())->setMaxResults($command->getNoResults());

        $qb = $this->addFilters($qb, $command);

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function fetchCountFutureTasks(TaskSearchCommand $command)
    {
        $em = $this->entityManager;
        $qb = $em->createQueryBuilder();
        $qb->select('count(t)')
            ->from($this->entity, 't')
            ->where(
                "1=1")->orderBy('t.dateTime', 'ASC');

        $qb = $this->addFilters($qb, $command);
        $query = $qb->getQuery();
        return $query->getResult()[0][1];
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param TaskSearchCommand $command
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function addFilters(\Doctrine\ORM\QueryBuilder $qb, TaskSearchCommand $command)
    {
        if ($command->showOnlyFuture()) {
            $qb->andWhere($qb->expr()->gte('t.dateTime', "CURRENT_TIMESTAMP()"));
        } else {
            $qb = $this->addStartEndDateFilters($qb, $command);
        }

        if ($command->getTipCursa() != null) {
            $qb->andWhere($qb->expr()->eq("t.cursa", ":tipCursa"));
            $qb->setParameter(":tipCursa", $command->getTipCursa());
        }

        if ($command->getFilter() != null) {
            if (is_numeric($command->getFilter())) {
                $qb->andWhere($qb->expr()->eq("t.id", $command->getFilter())); //it's nice to have a search by id
            } else {
                $filter = "%" . $command->getFilter() . "%";
                $qb->setParameter(":filter", $filter);
                $qb->andWhere($qb->expr()->like("t.fullTask", ":filter"));
            }
        }
        return $qb;
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param $command AbstractTaskSearchCommand
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function addStartEndDateFilters(\Doctrine\ORM\QueryBuilder $qb, $command)
    {
        if ($command->getEndDate() != null) {
            $qb->andWhere($qb->expr()->lte('t.dateTime', ":endDate"));
            $qb->setParameter(":endDate", $command->getEndDate(), \Doctrine\DBAL\Types\Type::DATETIME);
        }
        if ($command->getStartDate() != null) {
            $qb->andWhere($qb->expr()->gte('t.dateTime', ":startDate"));
            $qb->setParameter(":startDate", $command->getStartDate(), \Doctrine\DBAL\Types\Type::DATETIME);
        }
        return $qb;
    }

    /**
     * select distinct vehicleNo, sum(distance) from tasks where vehicleNo<>'' group by vehicleNo
     * select distinct sofer, sum(distance) from tasks where vehicleNo<>'' group by sofer
     * @param $command
     * @return array
     */
    public function aggregateDistancePerCriteria($command)
    {
        $em = $this->entityManager;
        $qb = $em->createQueryBuilder();

        $criteria = $command->getCriteria();

        $qb->select('distinct t.' . $criteria . ",sum(t.distance) as distance ")
            ->from($this->entity, 't')
            ->where("t." . $criteria . "<>''")
            ->andWhere("t.deletedAt IS NULL")
            ->groupBy("t." . $criteria);

        $qb = $this->addStartEndDateFilters($qb, $command);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * @param $command StatsSearchCommand
     * @return mixed
     */
    public function updateDriverOrVehicleByCriteria($command)
    {
        $em = $this->entityManager;
        $qb = $em->createQueryBuilder();

        $qb->update($this->entity, "t")
            ->set("t." . $command->getCriteria(), "?0")
            ->where("t." . $command->getCriteria() . "=?1")
            ->setParameter("1", $command->getOldValue())
            ->setParameter("0", $command->getNewValue());
        $query = $qb->getQuery();
        return $query->getResult();
    }
}