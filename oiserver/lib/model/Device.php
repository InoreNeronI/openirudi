<?php

/**
 * Subclass for representing a row from the 'device' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Device extends BaseDevice {
    function __toString() {
        if($this->name)
            return $this->name;
        else
            return 'NULL';
    }
}
