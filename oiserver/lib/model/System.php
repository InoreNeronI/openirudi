<?php

/**
 * Subclass for representing a row from the 'system' table.
 *
 * 
 *
 * @package lib.model
 */ 
class System extends BaseSystem {
    function __toString() {
        if($this->name)
            return $this->name;
        else
            return 'NULL';
    }
}
