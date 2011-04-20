<?php

class MyTask extends BaseMyTask
{
	
	public function __toString(){
		return (string) $this->id;
	}	
	public function getDayCustom(){
		return OiimagesPeer::get_custom_format_date($this->getDay());
	}
	public function save(PropelPDO $con = null)
	{
		if($this->associate){
			$this->setDay('');
			$this->setHour('');
		}else{
			if(!$this->hour){
				$this->setHour('00:00');
			}
		}

		parent::save($con);
	}
	/*public function delete(PropelPDO $con = null)
	{
		//kam
		PcPeer::clear_task($this->id);
		//		

		parent::delete($con);
	}*/
	public function get_my_hour(){
		$my_array=explode(':',$this->hour);

		if(count($my_array)==3){
			$my_array=array_slice($my_array,0,2);
		}

		return implode(':',$my_array);
	}
}
