<?php

/**
 * Subclass for representing a row from the 'type' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Type extends BaseType {

    public function getVendorsByTypeId() {
       return $this->getId();
    }

    function __toString() {
        return $this->type;
    }
}
