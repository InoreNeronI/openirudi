<?php

class OiimagesPeer extends BaseOiimagesPeer
{
	public static function get_custom_format_date($date){
		if(!empty($date)){
			$cfg=$date;
			$culture=sfContext::getInstance()->getUser()->getCulture();
			switch($culture){
				case 'es':
					$my_array=explode(' ',$date);
					if(count($my_array)>1){
						$my_date=explode('/',$my_array[0]);
						if(count($my_date)>2){
							$cfg=implode('/',array_reverse($my_date)).' '.$my_array[1];
						}					
					}
					break;
				default:
					$cfg=$date;
					break;	
			}
			return $cfg;
		}
		return '';
	}
	public static function get_oiimages_list(){
		$c=new Criteria();
		$c->addAscendingOrderByColumn(self::NAME);
		return self::doSelect($c);
	}
	public static function get_oiimages_assoc($oiimages_list){
		$result=array();
	
		if(count($oiimages_list)>0){
			$result[0]='';
			foreach($oiimages_list as $i=>$row){
				$result[$row->getId()]=$row->getName();
			}			
		}

		return $result;
	}
	public static function is_empty_oiimage($oiimages_id_array){
		if(count($oiimages_id_array)>0){

			foreach($oiimages_id_array as $key=>$value){
				if(!empty($value)){
					return 0;
				}	
			}
		}
                $request=sfContext::getInstance()->getRequest();
		if($request->getParameter('is_imageset')){
			return 0;
		}

		//gemini 2011-02-15
		$request=sfContext::getInstance()->getRequest();
		if($request->getParameter('is_imageset')){
			return 0;
		}
		//

		return 1;
	}
    //gemini
    public static function get_mm_array(){
		$result=array();
		$criteria=new Criteria();
		$criteria->addAscendingOrderByColumn(self::NAME);
		$my_list=self::doSelect($criteria);

		if(count($my_list)>0){
			foreach($my_list as $i=>$image){
				$row=array();
				$row['id']=$image->getId();
				$row['izen']=$image->getName();
				$row['icon']='';
				$result[]=$row;
			} 			
		}

		return $result;
    }
	//gemini
	public static function get_oiimages_array($imageset_id){		
		$criteria=new Criteria();
		$criteria->addJoin(self::ID,AsignImagesetPeer::OIIMAGES_ID,Criteria::LEFT_JOIN);
		$criteria->add(AsignImagesetPeer::IMAGESET_ID,$imageset_id);
		$criteria->addAscendingOrderByColumn(self::NAME);
		return self::doSelect($criteria);
	}
}
