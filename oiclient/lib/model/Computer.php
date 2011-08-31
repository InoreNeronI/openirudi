<?php

/**
 * Subclass for representing a row from the 'computer' table.
 *
 *
 *
 * @package lib.model
 */
class Computer extends BaseComputer
{
	function __construct(){
		$this->hw = new hardwareDetectOppClass();
	}

	/**
	 * Obtener la placa base
	 */
	 function getMotherBoard() {
	 	 return $this->hw->motherBoard();
	 }
}
