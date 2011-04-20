<?php

/**
 * Subclass for representing a row from the 'subsys' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Subsys extends BaseSubsys {
    function __toString() {
        if($this->name)
            return $this->name;
        else
            return 'NULL';
    }
}
