<?php
/**
 * Created by PhpStorm.
 * User: miki
 * Date: 14.04.2015
 * Time: 00:16
 */

namespace Transp\Service;

use Transp\Entities\AutoComplete;
use Transp\Service\Interf\AbstractService;

interface IAutoCompleteService
{

    /**
     * Returns an array of strings auto completed sorted by rank for a specific string'
     * @param $word
     * @return AutoComplete[]
     */
    public function fetch($word);

    /**
     * Inserts if not exist;
     * If exists increases rank;
     * @param $word
     * @return mixed
     */
    public function upsertWord($word);

    /**
     * removes a word.
     * @param $word
     * @return mixed
     */
    public function delete($word);

}

class AutoCompleteService extends AbstractService implements IAutoCompleteService
{

    /**
     * Returns an array of strings auto completed sorted by rank for a specific string'
     * @param $word
     * @return AutoComplete[]
     */
    public function fetch($word)
    {
        $words = $this->getAutoCompleteRepository()->findMatchingByWord($word);
        return $words;
    }

    /**
     * Inserts if not exist;
     * If exists increases rank;
     * @param $word
     * @return mixed
     */
    public function upsertWord($word)
    {
        if (strlen($word) > 1) {
            $this->getAutoCompleteRepository()->create($word);
        }
        return true;
    }

    /**
     * removes a word.
     * @param $entities
     * @return mixed
     */
    public function delete($word)
    {
        $toBeRemoved = $this->getAutoCompleteRepository()->findByWord($word);
        if ($toBeRemoved != null && sizeof($toBeRemoved) > 0) {
            $this->getAutoCompleteRepository()->delete($toBeRemoved[0]);
            return true;
        }
        return false;
    }
}