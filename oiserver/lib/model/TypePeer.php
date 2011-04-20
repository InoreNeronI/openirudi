<?php

/**
 * Subclass for performing query and update operations on the 'type' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TypePeer extends BaseTypePeer
{
    static function getTypeId($hw_type) {
        $c1 = new Criteria();
        $c1->add(self::TYPE, $hw_type, Criteria::LIKE);
        $t = self::doSelectOne($c1);
        if (is_null($t)) {
            self::populateType();
            $t = self::doSelectOne($c1);
        }
        return $t->getId();
    }

    public static function populateType() {
        $types = sfConfig::get('app_hardware_types');
        foreach($types as $type) {
            $c2 = new Criteria();
            $c2->add(self::TYPE, $type, Criteria::LIKE);
            $t = self::doSelectOne($c2);
            if (is_null($t)) {
                $typ = new Type();
                $typ->setType($type);
                try {
                    $typ->save();
                } catch(Exception $e) {
                    if (strpos($e->getMessage(), 'Duplicate entry') !== false)  continue;
                }
            }
        }

        $types = self::doSelect(new Criteria());

        foreach($types as $type) {
            $result[strtolower($type->getType())] = $type->getId();
        }

        return $result;
    }
}
