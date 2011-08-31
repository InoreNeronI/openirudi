<?php
class lshwParseClass{
	function __construct(){

	}

	function hardwareList($xml){
                $xml2=utf8_encode($xml);
		$xmlObj = simplexml_load_string($xml2);
		$dd=$this->xml2array($xmlObj);

		return $dd;
	}

	function xml2str($xmlObj){
		$r='';
		foreach ($xmlObj as $k =>$v){
			$rr=trim((string)$v);
			$attributes=$v->attributes();
			$value=trim((string)$attributes->value);
			$id=trim((string)$attributes->id);
			if(!empty($value)){
				$r.=" $id=$value ";
			}else{
				$r.=" $rr ";
			}
		}
		return $r;
	}

	function xml2array($xmlObj){
		if(empty($xmlObj)) return;
		$attrib=$xmlObj->attributes();
		$children=$xmlObj->children();
		$id1=(string)$attrib->id;
		$res=array();

		foreach ($xmlObj as $key => $val ){
			$strVal=trim((string)$val);
			$attributes=$val->attributes();

			$id2=trim((string)$attributes->id);

			$att['class']=trim((string)$attributes->class);
			$att['description']=trim((string)$attributes->description);
			$att['handle']=trim((string)$attributes->handle);
			$att['disabled']=trim((string)$attributes->disabled);

			if(empty($strVal)){
				switch($key){
					case 'node':
						$res[$id2]=$this->xml2array($val);

						//if(!empty($class)){
							$res[$id2]['attributes']=$att;
						//}

						break;
					default:
						$res[$key]=$this->xml2str($val);
				}
			}else{
				$res[$key]=$strVal;
			}
		}
		return $res;
	}

	function getHardwareClass($className,$hardwareArray){
		$result=array();
		foreach ( $hardwareArray as $key => $value ){
			if( is_array($value) ){
				if( !empty( $value['attributes']['class']) &&  $value['attributes']['class']==$className ){
					$result[]=$value;
				}else{
					$result=array_merge($result,$this->getHardwareClass($className,$value));
				}
			}
		}
		return $result;
	}

}
?>
