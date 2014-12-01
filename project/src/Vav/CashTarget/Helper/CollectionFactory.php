<?php
/**
 * Collection creator for appropriate DomainObject
 *
 * @package Vav\CashTarget\Helper
 * @author Alexey Varlamov
 */

namespace Vav\CashTarget\Helper;

use Vav\CashTarget\Model\Mapper\Collection\Goal;

class CollectionFactory
{
    /**
     * Create DomainObject collection depending on DomainObject instance
     *
     * @param string $type
     * @return \Vav\CashTarget\Model\Mapper\Collection
     */
    public static function getCollection($type)
    {
        $collection = null;
        switch($type) {
            case 'Vav\\CashTarget\\Model\\Domain\\Goal':
                $collection = new Goal();
        }

        return $collection;
    }
} 