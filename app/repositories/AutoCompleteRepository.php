<?php
/**
 * Created by PhpStorm.
 * User: miki
 * Date: 14.04.2015
 * Time: 00:33
 */

namespace Transp\repositories;

use Transp\Entities\AutoComplete;
use Transp\Repositories\Interf\AbstractRepository;
use Transp\Repositories\Interf\IRepository;

interface IAutoCompleteRepository extends IRepository
{

    /**
     * @param $word
     * @return array[]
     */
    public function findMatchingByWord($word);

    /**
     * @param $word
     * @return mixed
     */
    public function create($word);

    public function findByWord($word);

}

class AutoCompleteRepository extends AbstractRepository implements IAutoCompleteRepository
{

    private $entity = "Transp\Entities\AutoComplete";
    /**
     * max numbers of auto complete results;
     * @var int
     */
    private static $MAX_RESULTS = 5;

    private static $WORD_UPSERT = "INSERT INTO auto_complete (word,rank) VALUES(:word,0)
      ON DUPLICATE KEY UPDATE rank = rank +1;";


    protected function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param $word
     * @return array[]
     */
    public function findMatchingByWord($word)
    {
        $em = $this->entityManager;
        $qb = $em->createQueryBuilder();

        $qb->select(array('t'))
            ->from($this->entity, 't')
            ->where(
                "1=1")
            ->andWhere($qb->expr()->like("t.word", ":word"))
            ->orderBy('t.rank', 'DESC')
            ->setMaxResults(self::$MAX_RESULTS);

        $word = $word . "%";
        $qb->setParameter(":word", $word);

        $query = $qb->getQuery();
        return $query->getResult();
    }



    /**
     * INSERT INTO auto_complete (word,rank) VALUES("test",0) ON DUPLICATE KEY UPDATE
     * rank = rank +1;
     */
    /**
     * @param $word
     * @return bool
     */
    public function create($word)
    {
        /**
         * $sql = self::$WORD_UPSERT;
         * $stmt = $this->entityManager->getConnection()->prepare($sql);
         * $stmt->bindParam(":word", $word);
         * $stmt->execute();
         */
        $already = $this->findByWord($word);
        if (sizeof($already) == 0) {
            $already = new AutoComplete();
            $already->setWord($word);
            parent::create($already);
        } else {
            $toUpdate = $already[0];
            $toUpdate->setRank($toUpdate->getRank() + 1);
            $this->update($toUpdate);
        }
        return true;
    }

    public function findByWord($word)
    {
        $em = $this->entityManager;
        $qb = $em->createQueryBuilder();

        $qb->select(array('t'))
            ->from($this->entity, 't')
            ->where(
                "1=1")
            ->andWhere($qb->expr()->eq("t.word", ":word"))
            ->setMaxResults(self::$MAX_RESULTS);

        $qb->setParameter(":word", $word);

        $query = $qb->getQuery();
        return $query->getResult();
    }
}