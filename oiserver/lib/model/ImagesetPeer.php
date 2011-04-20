<?php

class ImagesetPeer extends BaseImagesetPeer
{
	
	//gemini
	//gaur static jarri
	public static function get_imageset_assoc(){
		$result=array();
		$result['']='';
		$c=new Criteria();
		$c->addAscendingOrderByColumn(self::NAME);
		$list=self::doSelect($c);
		if(count($list)>0){
			foreach($list as $i=>$row){
				$result[$row->getId()]=$row->getName();
			}
		}
		return $result;
	}
}
