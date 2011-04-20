<?php

class Imageset extends BaseImageset
{
	//gemini
    public function delete(PropelPDO $con = null)
	{
		AsignImagesetPeer::delete_asign_imageset($this->id);
		parent::delete($con);
	}
	//gemini
	public function getOiimages_list(){
		$result='';
		$my_list=OiimagesPeer::get_oiimages_array($this->id);
		if(count($my_list)>0){
			$my_array=array();
			foreach($my_list as $i=>$r){
				$name=$r->getName();
				if(!empty($name)){
					$my_array[]=$name;
				}
			}
			$result=implode(',',$my_array);
		}
		return $result;
	}


	//gemini 2011-02-15
	public function __toString(){
		return $this->name;
	}
}
