<?php

/**
 * Subclass for representing a row from the 'path' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Path extends BasePath {
    function __toString() {
        if($this->path)
            return $this->path;
        else
            return 'NULL';
    }
	/*
	//kam
	public function getType(){
		
		$driver=$this->getDriver();

		if(!empty($driver)){
			$type=$driver->getType();
			if(!empty($type)){
				return $type;
			}
		}

		return '';
	}
	//kam
	public function getVendor(){
		
		$driver=$this->getDriver();

		if(!empty($driver)){
			$vendor=$driver->getVendor();
			if(!empty($vendor)){
				return $vendor;
			}
		}

		return '';
	}
	//kam
	public function getDevice(){
		
		$driver=$this->getDriver();

		if(!empty($driver)){
			$device=$driver->getDevice();
			if(!empty($device)){
				return $device;
			}
		}

		return '';
	}*/
}
