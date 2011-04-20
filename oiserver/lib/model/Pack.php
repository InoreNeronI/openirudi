<?php

/**
 * Subclass for representing a row from the 'pack' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Pack extends BasePack {
    function __toString() {
        if($this->name)
            return $this->name;
        else
            return 'NULL';
    }
}
