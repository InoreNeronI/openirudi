<?php

class AsignImagesetPeer extends BaseAsignImagesetPeer
{
	//gemini
	public static function save_asign_imageset($imageset_id){
		self::delete_asign_imageset($imageset_id);		
		$request=sfContext::getInstance()->getRequest();
		$partition_names=$request->getParameter('partition_names');
		$type=$request->getParameter('type');
		$partition_sizes=$request->getParameter('partition_sizes');
		$partition_colors=$request->getParameter('partition_colors');
		//
		$partition_names=array_values($partition_names);
		$type=array_values($type);
		$partition_sizes=array_values($partition_sizes);
		$partition_colors=array_values($partition_colors);
		//
		$kont=0;
		$position=0;
		if(count($partition_names)>0){
			foreach($partition_names as $i=>$name){
				if(isset($type[$kont]) && isset($partition_sizes[$kont]) && isset($partition_colors[$kont])){
					$oiimages_id=$type[$kont];
					$size=$partition_sizes[$kont];
					$color=$partition_colors[$kont];					
					self::insert_asign_imageset($name,$imageset_id,$oiimages_id,$size,$position,$color);
					$position++;
				}
				$kont++;
			}
		}
	}
	//gemini
	public static function delete_asign_imageset($imageset_id){
		$con = Propel::getConnection();

		$sql='DELETE FROM asign_imageset WHERE imageset_id='.$imageset_id;
 		$stmt = $con->prepare($sql);

        $stmt->execute();
	}
	//gemini
	private static function insert_asign_imageset($name,$imageset_id,$oiimages_id,$size,$position,$color){
		$con = Propel::getConnection();

		$sql='INSERT INTO asign_imageset(name,imageset_id,oiimages_id,size,position,color) VALUES("'.$name.'",'.$imageset_id.','.$oiimages_id.','.$size.','.$position.',"'.$color.'")';
 		
		$stmt = $con->prepare($sql);

        $stmt->execute();
	}
	//gemini
	public static function get_pp_array($imageset_id='',$size=0){
		$result=array();
		if(!empty($imageset_id)){
			$criteria=new Criteria();
			$criteria->add(self::IMAGESET_ID,$imageset_id);
			$criteria->addAscendingOrderByColumn(self::ID);
			$my_list=self::doSelect($criteria);
			if(count($my_list)>0){
				$kont=0;
				foreach($my_list as $i=>$a){
					$row=array();
					$row['id']=$kont+1;
					//OHARRA::::name ez da erakutsi behar
					//$row['name']=$a->getName();
					$row['name']=$row['id'];
					$row['size']=$a->getSize();
					$row['type']=$a->getOiimagesId();
					$row['type_name']=$a->getOiimages();
					$row['color']=$a->getColor();
					$row['loked']=0;			
					$result[]=$row;
					$kont++;	
				}
			}
		}
		if(count($result)==0){
			$row=array();
			$row['id']=1;
			$row['name']=$row['id'];
			$row['size']=$size;
			$row['type']=0;
			$row['type_name']='';	
			$row['color']='';
			$row['loked']=0;			
			$result[]=$row;
		}
		return $result;
	}	
}
