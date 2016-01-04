<?php
/**
 * CMS: mcsere
 * Date: 8/29/14
 * Time: 3:56 PM
 * Contact: miki@softwareengineer.ro
 */

namespace Transp\Repositories\Structure;


use Transp\Entities\Structure\CMS;
use Transp\Entities\Structure\Lang;
use Transp\Repositories\Interf\AbstractRepository;
use Transp\Repositories\Interf\IRepository;

interface ICMSRepository extends IRepository
{

    public function getCMSListByLang(Lang $lang);


    /**
     * @param Lang $lang
     * @param Lang $defaultLang
     * @return  CMS[]
     */
    public function getCMSListWithDefault(Lang $lang, Lang $defaultLang);

    /**
     * @param $key
     * @param Lang $lang
     * @param Lang $defaultLang
     * @return CMS
     */
    public function getCMS($key, Lang $lang, Lang $defaultLang);

}

class CMSRepository extends AbstractRepository implements ICMSRepository
{

    private $entity = "Transp\Entities\Structure\CMS";
    private $queryFetchCMSLIST = "SELECT c.id,c.label,c.key,c.value,
                   cDefault.value as defaultValue
             FROM Transp\Entities\Structure\CMS c
             LEFT JOIN Transp\Entities\Structure\CMS cDefault
                WITH  c.key = cDefault.key AND cDefault.lang = :defaultLang
                WHERE c.lang = :lang";
    private $queryFetchCMS = " AND c.key=:key";


    protected function getEntity()
    {
        return $this->entity;
    }

    public function getCMSListByLang(Lang $lang)
    {
        return $this->entityManager->getRepository($this->getEntity())
            ->findBy(array("lang" => $lang));
    }

    /**
     * @param Lang $lang
     * @param Lang $defaultLang
     * @return  CMS[]
     */
    public function getCMSListWithDefault(Lang $lang, Lang $defaultLang)
    {
        $query = $this->entityManager->createQuery($this->queryFetchCMSLIST);
        $query->setParameter("lang", $lang->getId());
        $query->setParameter("defaultLang", $defaultLang->getId());

        $queryResult = $query->getResult();

        /**
         * @var CMS[]
         */
        $cmsList = array();
        foreach ($queryResult as $row) {
            array_push($cmsList, $this->toCMS($row, $lang));
        }

        return $cmsList;
    }

    public function getCMS($key, Lang $lang, Lang $defaultLang)
    {
        $query = $this->entityManager->createQuery($this->queryFetchCMSLIST . $this->queryFetchCMS);
        $query->setParameter("lang", $lang->getId());
        $query->setParameter("defaultLang", $defaultLang->getId());
        $query->setParameter("key", $key);

        //it should be only one
        $queryResult = $query->getResult();
        foreach ($queryResult as $row) {
            return $this->toCMS($row, $lang);
        }
        return null;
    }

    /**
     * @param $row
     * @param $lang
     * @return CMS
     */
    private function toCMS($row, $lang)
    {
        $cms = new CMS();
        $cms->setId($row["id"]);
        $cms->setLabel($row["label"]);
        $cms->setKey($row["key"]);
        $cms->setValue($row["value"]);
        $cms->setLang($lang);
        $cms->setDefaultValue($row["defaultValue"]);
        return $cms;
    }
}