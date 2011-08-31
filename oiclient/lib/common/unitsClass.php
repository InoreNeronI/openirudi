<?php
class unitsClass{

	static $sizeUnits = array('b'=>0.125, 'B'=>1,
														'KB'=>1024,
 														'MB'=>1048576,
														'GB'=>1073741824,
														'TB'=>1099511627776);

//	static $sizeUnits = array('B'=>1,
//														'KB'=>1000,
// 														'MB'=>1000000,
//														'GB'=>1000000000,
//														'TB'=>1000000000000);

	static function sizeUnit($size){
		$sizeUnits=unitsClass::listSizeUnits();
		if(is_array($size) && isset($size['size']) && isset($size['unit'])){
			$result=$size['size']*$sizeUnits[$size['unit']];
			return $result;
		}elseif(is_numeric($size)){
			$usize1=0;
			$unit1='';
			if(empty($size)){
				$result['size']=0;
				$result['unit']='B';
				return $result;
			}
			foreach($sizeUnits as $unit => $usize){
				if($size < $usize){
                                    $result['size']=floor($size*100/$usize1)/100;
                                    $result['unit']=$unit1;
                                    return $result;
				}
				$usize1=$usize;
				$unit1=$unit;
			}
			$result['size']=floor($size*100/$usize1)/100;
			$result['unit']=$unit1;
			return $result;

		}else{

		}
		return;
	}

	static function listSizeUnits($onlyUnits=false,$value=''){
		$l=unitsClass::$sizeUnits;
		if(!$onlyUnits && !isset($l[$value])){
			return $l;

		}elseif($onlyUnits && !isset($l[$value])){
			foreach (array_keys($l) as $u) $r[$u]=$u;
			return $r;

		}elseif(!$onlyUnits && isset($l[$value])){
			$la=array_keys($l);
			return array_search($value,$la);

		}elseif($onlyUnits && isset($l[$value])){
			return $l[$value];
		}
	}

	static function converse($size,$unit=''){
		$sizeUnits=unitsClass::listSizeUnits();

		if(is_array($size) && isset($size['size']) && isset($size['unit'])){
			$total=$size['size']*$sizeUnits[$size['unit']];
		}else{
			$total=$size;
		}

		if(empty($unit) || !isset($sizeUnits[$unit])){
			return unitsClass::sizeUnit($total);
		}else{
			$result['size']=floor($total*100/$sizeUnits[$unit])/100;
			$result['unit']=$unit;
			return $result;
		}
	}

	static function diskSectorSize($sectors,$unit='',$sectorBytes=0){
            if(empty($sectorBytes)) $sectorBytes=sfConfig::get('app_const_bytessector');
		//$sizeUnits=unitsClass::listSizeUnits();
                $bytes=$sectors * $sectorBytes;
                if(empty($unit)){
                    return unitsClass::sizeUnit($bytes);
                }else{
                    return self::converse(array('size'=>$bytes,'unit'=>'B'), $unit);
                }
	}

        static function diskSector2SizeHex($sectors,$unit='',$sectorBytes=0){
            if(empty($sectorBytes)) $sectorBytes=sfConfig::get('app_const_bytessector');
            $bytes=$sectors * $sectorBytes;
            return dechex($bytes);
	}

	static function size2sector($size,$sectorBytes=0){
            if(empty($sectorBytes)) $sectorBytes=sfConfig::get('app_const_bytessector');

            if(is_array($size) && isset($size['size']) && isset($size['unit'])){
                    $sizeUnits=unitsClass::listSizeUnits();
                    $sizeB=$size['size']*$sizeUnits[$size['unit']];
            }else{
                    $sizeB=$size;
            }
            return floor($sizeB / $sectorBytes);

	}

        static function longDec2hex($dec) {
            $sign = ""; 
            if( $dec < 0){ $sign = "-"; $dec = abs($dec); }

            $hex = Array( 0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5,
                          6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 'a',
                          11 => 'b', 12 => 'c', 13 => 'd', 14 => 'e',
                          15 => 'f' );
            $h='';
            do {
                $h = $hex[($dec%16)] . $h;
                $dec /= 16;
            } while( $dec >= 1 );

            return $sign . $h;
        }

}

?>
