<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ParseINF {

    static $file;
    static $fileParsed;

    static function operate($dir) {
        $types = TypePeer::populateType();
        $t1 = time();
        $infs = array();
        if (is_array($dir)) {
            $infs = $dir;
        } elseif (is_file($dir)) {
            $infs[] = $dir;
        } elseif (is_dir($dir)) {
            $infs = self::listinf($dir, '.inf');
            //$infs = self::listinf($dir.'/LAN', '.inf');
        } else  return false;
        unset($dir);
        $corrupt_inf = 0;
        $version_gabe = 0;
        $ez_provider_ez_manufacturer = 0;
        $provider_gabe = 0;
        $ez_manufacturer = 0;
        $sekzio_gabe = 0;
        $guztira = 0;
        $typ_cont = 0;
        $ven_cont = 0;
        $dev_cont = 0;
        $sub_cont = 0;
        $dr_cont = 0;
        $dr_cont_update = 0;
        foreach ($infs as $file) {
//            echo '<br />Archivo: ';print_r($file).'<br />';
            self::parse($file);
            $infArray = self::getParam('version');
//            echo '<br />';
//            print_r($infArray);
//            echo '<br /><br />----<br />';
            $manufacturer = self::getParam('manufacturer');
            if (empty($infArray)) {
                $corrupt_inf ++;
                continue;
            } elseif (!isset($infArray['version']) || empty($infArray['version'])) {
                $version_gabe ++;
                continue;
            } elseif ((!isset($infArray['version']['provider']) || empty($infArray['version']['provider'])) && (!is_array($manufacturer) || empty($manufacturer))) {
                $ez_provider_ez_manufacturer ++;
                continue;
            } elseif (!isset($infArray['version']['provider']) || empty($infArray['version']['provider'])) {
                $provider_gabe ++;
                continue;
            } elseif (!is_array($manufacturer) || empty($manufacturer)) {
                $ez_manufacturer ++;
                continue;
            } elseif (is_array($manufacturer) && !empty($manufacturer)) {
                $devices = array();
				$secs = array();
                foreach ($manufacturer['manufacturer'] as $d) {
                    $sp = explode(',', $d);
                    $secs[] = trim($sp[0]);
                    if(count($sp) > 1) {
						$i = 1;
						foreach ($sp as $s) {
				            if ($s == $sp[0])       continue;
				            if (trim($s) != '')     $secs[] = trim($sp[0]).'.'.trim($s);
				            if ($i < count($sp))   	$i++;
				            else    break;
						}
                    } else  $secs[] = $d;
                    unset($d, $i, $sp);
                }
				foreach ($secs as  $sec) {
                    $dp = self::getParam($sec);
                    unset($sec);
                    if(empty($dp) || !is_array($dp)) {
                        //echo "\n manufacturer sekzioko $sec ez du sekziorik<br />";
                        //$sekzio_gabe ++;
                        unset($dp);
                        continue;
                    } else {
                        $devices = array_merge($devices, $dp);
                        unset($dp);
                    }
                }
                //echo '<br />Sec: ';print_r($devices);echo '<br /><br />';
                unset($secs);
            }
            unset($manufacturer);
            foreach ($devices as $file_devices) {
                foreach ($file_devices as $id => $dev) {
                    $string = array();
                    $dev2 = explode(',', $dev);
//                    echo '<br />----<br />';print_r($dev2);echo '<br />';
                    if (count($dev2) > 1) {
                        if (trim($dev2[1]) == '' && !isset($dev2[2]))   continue;
						elseif (trim($dev2[1]) == '') {
                            $dev2[1] = trim($dev2[2]);
                            unset($dev2[2]);
						}
						if (preg_match('/^(pci).(ven)_([0-9a-z]{4})&(dev)_([0-9a-z]{4})&(subsys)_([0-9a-z]{8})&(rev)_([0-9a-z]{2})$/i', trim($dev2[1]), $vd)) {
			                $string = $vd;
						} elseif (preg_match('/^(pci).(ven)_([0-9a-z]{4})&(dev)_([0-9a-z]{4})&(subsys)_([0-9a-z]{8})$/i', trim($dev2[1]), $vd)) {
			                $string = $vd;
						} elseif (preg_match('/^(pci|usb|hid).(ven|vid)_([0-9a-z]{4})&(dev|pid)_([0-9a-z]{4})$/i', trim($dev2[1]), $vd)) {
			                $string = $vd;
						} elseif (preg_match('/^(pci).(ven)_([0-9a-z]{4})&(dev)_([0-9a-z]{4})&(cc)_([0-9a-z]{6})$/i', trim($dev2[1]), $vd)) {
			                $string = $vd;
			            } elseif (preg_match('/^(pci).(ven)_([0-9a-z]{4})&(dev)_([0-9a-z]{4})&(cc)_([0-9a-z]{4})$/i', trim($dev2[1]), $vd)) {
			                $string = $vd;
						} elseif (preg_match('/^(pci).(ven)_([0-9a-z]{4})&(cc)_([0-9a-z]{6})$/i', trim($dev2[1]), $vd)) {
		                	$string = $vd;
			            } elseif (preg_match('/^(pci).(ven)_([0-9a-z]{4})&(cc)_([0-9a-z]{4})$/i', trim($dev2[1]), $vd)) {
			                $string = $vd;
						} elseif (preg_match('/^(pci).(cc)_([0-9a-z]{6})$/i', trim($dev2[1]), $vd)) {
			                $string = $vd;
						} elseif (preg_match('/^(pci).(cc)_([0-9a-z]{4})$/i', trim($dev2[1]), $vd)) {
			                $string = $vd;
						} elseif (preg_match('/^(hdaudio).(.*)$/i', trim($dev2[1]), $vd)) {
			                $string = $vd;
						} elseif (preg_match('/^(pcmcia).(.*)$/i', trim($dev2[1]), $vd)) {
			                $string = $vd;
						} elseif (preg_match('/^(scsi).(.*)$/i', trim($dev2[1]), $vd)) {
			                $string = $vd;
						} elseif (preg_match('/^(acpi).(.*)$/i', trim($dev2[1]), $vd)) {
			                $string = $vd;
						} elseif (preg_match('/^(\*)(.*)$/i', trim($dev2[1]), $vd)) {
			                $string = $vd;
						}
                    }
                    if (is_numeric(substr($id, strrpos($id, '_') + 1))) {
                        $name = ucwords(substr($id, 0, strrpos($id, '_')));
                    } else  $name = ucwords($id);
					unset($dev, $dev2, $vd, $id);
					if (isset($string) && !empty($string)) {
                            $root_url = substr(self::selfURL(), 0, strrpos(self::selfURL(), 'drivers') + 7);
                            $target_path =  substr($file, strlen(sfConfig::get('app_const_root_dir')), strlen($file));
                            $url = $root_url.$target_path;
                            if (isset($infArray['version']['driverver'])) {
                                $date = DriverPeer::version($infArray['version']['driverver']);
                            } else  $date = '00/00/0000';
/// TODO /////////////////////////// TODO //////////////////////////////////////////////
                            if (substr(trim($string[0]), 0, 1) == '*')  continue;
                            elseif (trim($string[1]) == 'hdaudio')  continue;
                            elseif (trim($string[1]) == 'pcmcia')  continue;
                            elseif (trim($string[1]) == 'scsi')  continue;
                            elseif (trim($string[1]) == 'acpi')  continue;
                            elseif (isset($string[2]) && trim($string[2]) == 'cc')  continue;
                            elseif (isset($string[4]) && trim($string[4]) == 'cc')  continue;
                            elseif (isset($string[6]) && trim($string[6]) == 'cc')  continue;
////////////////////////////////////////////////////////////////////////////////////////
                            $tid = $types[strtolower($string[1])];
////////////////////////////////////////////////////////////////////////////////////////
//                            echo('Type: '.($tid).'<br />'.'Vid: '.($string[3]).'<br />');
//                            echo('Did: '.($string[5]).'<br />'.'Class_type: '.($infArray['version']['class']).'<br />');
//                            echo('Date: '.($date).'<br />'.'Name: '.($name).'<br />');
//                            echo('String: '.($string[0]).'<br />'.'Url: '.(pathinfo($root_url.$target_path, PATHINFO_DIRNAME)).'<br />');
////////////////////////////////////////////////////////////////////////////////////////
                            $driver = new Driver();
                            $driver->setTypeId($tid);
                            //if (isset($string[3]))
                            $driver->setVendorId($string[3]);
                            //if (isset($string[5]))
                            $driver->setDeviceId($string[5]);
                            $driver->setClassType($infArray['version']['class']);
                            $driver->setDate($date);
                            $driver->setName($name);
                            $driver->setString($string[0]);
                            $driver->setUrl($url);
                            try {
                                $driver->save();
                                $save = DriverPeer::saveDriver($string, $driver, $dr_cont, $sub_cont, $infArray['version']['signature'], $file);
                                $sub_cont = $save[0];
                                $dr_cont = $save[1];
                            } catch(Exception $e) {
                                if (strpos($e->getMessage(), 'FOREIGN KEY') !== false) {
                                //Check if Vendor exists
                                $vendor = VendorPeer::retrieveByPK($string[3], $tid);;
                                if (is_null($vendor)) {
                                    $ven = new Vendor();
                                    $ven->setCode($string[3]);
                                    $ven->setTypeId($tid);
                                    $ven->save();
                                    $vid = $ven->getCode();
                                    unset($ven);
                                    $ven_cont ++;
                                } else  $vid = $vendor->getCode();
                                unset($c, $vendor);
                                $driver->setVendorId($vid);
                                //Check if Device exists
                                $c = new Criteria;
                                $c->add(DevicePeer::CODE, $string[5]);
                                $c->add(DevicePeer::VENDOR_ID, $vid);
                                $c->add(DevicePeer::TYPE_ID, $tid);
                                $device = DevicePeer::doSelectOne($c);
                                if (is_null($device)) {
                                    $dev = new Device();
                                    $dev->setCode($string[5]);
                                    $dev->setVendorId($vid);
                                    $dev->setTypeId($tid);
                                    $dev->save();
                                    $did = $dev->getCode();
//                                    $device_id = $dev->getId();
                                    unset($dev);
                                    $dev_cont ++;
                                } else {
                                    $did = $device->getCode();
//                                    $device_id = $device->getId();
                                }
                                unset($c, $device);
                                $driver->setDeviceId($did);
                                $driver->save();
                            } elseif (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                                $c = new Criteria;
                                $c->add(DriverPeer::STRING, $string[0]);
                                $driver_old = DriverPeer::doSelectOne($c);
                                $dr_id = $driver_old->getId();
                                $date_old = $driver_old->getDate();
                                if (strpos('-', $date_old) === false)   list($anyo1, $mes1, $dia1) = explode('/', $date_old);
                                else    list($anyo1, $mes1, $dia1) = explode('-', $date_old);
                                list($mes2, $dia2, $anyo2) = explode('/', $date);
                                $dif = mktime(0, 0, 0, $mes1, $dia1, $anyo1) - mktime(0, 0, 0, $mes2, $dia2, $anyo2);
                                if ($dif < 0) {
                                    if (DriverPeer::dbUpdateHook($infArray['version']['class'], $date, $name, $url, $dr_id)) {
                                        $dr_cont_update ++;
                                        DriverPeer::updateDriverDependencies($string, $dr_id, $infArray['version']['signature'], $file);
                                    }
                                }
                                unset($dr_id, $anyo1, $mes1, $dia1, $mes2, $dia2, $anyo2, $dif);
                                unset($tid, $vid, $did, $url, $c, $driver_old);
                            }
                            unset($vid, $did);
                        }
                        unset($driver);
////////////////////////////////////////////////////////////////////////////////////////
                        unset($target_path, $root_url, $date);
                        }
                    unset($string, $name);
                }
				unset($file_devices);
            }
            unset($devices, $file);
            $guztira ++;
        }
		unset($infs);
        $t2 = time();
        $time = $t2 - $t1;
        $infs = $guztira + $corrupt_inf + $version_gabe + $provider_gabe + $ez_manufacturer + $ez_provider_ez_manufacturer;
        $processed_infs = $guztira;
        $not_processed_infs = $corrupt_inf + $version_gabe + $provider_gabe + $ez_manufacturer + $ez_provider_ez_manufacturer;
        return array($time, $infs, $processed_infs, $not_processed_infs, $corrupt_inf, $version_gabe, $provider_gabe, $ez_manufacturer, $ez_provider_ez_manufacturer, $typ_cont, $ven_cont, $dev_cont, $sub_cont, $dr_cont, $dr_cont_update);
    }

    static function listinf($path, $sPattern = '') {
        $result = array();
        if (is_dir($path)) {
            $handle = opendir($path);
            while (false !== ($file = readdir($handle))) {
                $newPath = $path.DIRECTORY_SEPARATOR.$file;
                if (is_dir($newPath) && $file != '.' && $file != '..' ) {
                    $result = array_merge($result, self::listinf($newPath, $sPattern));
                } elseif($file != '.' && $file != '..') {
                    if (empty($sPattern)) {
                        $result[] = $newPath;
                    } else {
                        if (preg_match('/'.$sPattern.'/i', $file)) {
                            $result[] = $newPath;
                        }
                    }
                }
            }
            closedir($handle);
        }
        return $result;
    }

    static function parse($file, $process_sections = true) {
        $process_sections = ($process_sections !== true) ? false : true;
        if (empty($file) || !is_file($file)) {
            ////echo "\n --{$file}-- is not valid file";
            //not valid file
            return;
        } else {
            $mime_type = null;
            //Needs for this:  PECL FileInfo library or PHP >= 5.3.0 and mime-files in 'extras' directory
            $handle = new finfo(FILEINFO_MIME, sfConfig::get('app_const_packs_root').'/magic');
            $content = file_get_contents($file);
            $mime_type = $handle->buffer($content);
            unset($handle);
            //
            if ($mime_type == 'audio/mpeg')	$content = html_entity_decode(self::ucs2html($content));
            unset($mime_type);
            $ini = explode("\n", $content);
            unset($content);
            self::$file = $file;
        }
        if (count($ini) == 0)   return array();
        $sections = array();
        $values = array();
        $result = array();
        $globals = array();
        $i = 0;
        $k = 1;
        foreach ($ini as $line) {
            $line = trim($line);
            $line = str_replace("\t", " ", $line);
            if (!preg_match('/^["a-zA-Z0-9%*[]/', $line))	continue;	// Comments
            if ($line{0} == '[') {	// Sections
                $tmp = explode(']', $line);
                $s = strtolower(trim(substr($tmp[0], 1)));
                $s = str_replace('"', '', $s);
                $sections[] = $s;
                $i++;
                continue;
            }
            if (strpos($line, '=') === false)   continue;
            // Key-value pair
            list($key, $value) = explode('=', $line, 2);
            $key = trim(strtolower(str_replace('"', '', $key)));
            $value = trim(strtolower(str_replace('"', '', $value)));
            if (strstr($value, ";")) {
                $tmp = explode(';', $value);
                if (count($tmp) == 2) { //Komentarioak kendu kate amaieran
                    if ((($value{0} != '"') && ($value{0} != "'")) ||
                        preg_match('/^".*"\s*;/', $value) || preg_match('/^".*;[^"]*$/', $value) ||
                        preg_match("/^'.*'\s*;/", $value) || preg_match("/^'.*;[^']*$/", $value)) {
                        $value = $tmp[0];
                    }
                } else {
                    if ($value{0} == '"')   $value = preg_replace('/^"(.*)".*/', '$1', $value);
                    elseif ($value{0} == "'")   $value = preg_replace("/^'(.*)'.*/", '$1', $value);
                    else    $value = $tmp[0];
                }
            }
            $value = trim($value);
            $value = trim($value, "'\"");
            if ($i == 0) {	//Ezta hemendik pasten...
                $globals[$key] = $value;
            } else {	//...beti hemendik...
                if (isset($values[$sections[$i-1]][$key]))  {
                    $key .= '_'.$k;
                    $k ++;
                }
                $values[$sections[$i-1]][$key] = $value;
            }
        }
        self::$fileParsed = $globals + $values;
    }

    static function getParam($iparams) {
        if (empty(self::$fileParsed))	return;	//no inf file
        if(is_array($iparams))  $params = $iparams;
        else  $params[] = $iparams;
        if (isset(self::$fileParsed['strings']))  $var = self::$fileParsed['strings'];
        foreach ($params as $p) {
            if (!isset(self::$fileParsed[$p]))  continue;
            else    $result[$p] = self::$fileParsed[$p];
            if (is_array($result[$p])) {
                $i = 1;
                foreach ($result[$p] as $key => $value) {
                    if (strpos($key, '%') !== false && substr_count($key, '%') / 2 <= 1) {
                        if (is_numeric(substr($key, strrpos($key, '%') + 2, strlen($key) - strrpos($key, '%') + 2))
                            && substr($key, strrpos($key, '%') + 1 == '_')) {
                            $k = str_replace('%', '', substr($key, 0, strrpos($key, '%')));
                        } else {
                            $k = str_replace('%', '', $key);
                        }
                        if (isset($var[$k])) {
                            if ($result[$p][$key] == $value)    unset($result[$p][$key]);
                            $key = $var[$k];
                            if (isset($result[$p][$key])) {
                                $key .= '_'.$i;
                                $i ++;
                            }
                        }
                        $result[$p][$key] = $value;
                    }
                    if (strpos($value, '%') !== false) {
                        $vbles = substr_count($value, '%') / 2; //Cuento numero de vbles=>parejas de %
                        $offset = 0;
                        for ($i = $vbles; $i > 0; $i--) {  //Por cada una de ellas
                            $begining = strpos($value, '%', $offset) + 1;  //Guardo la posicion inicial de la vble actual
                            $ending = strpos($value, '%', $begining);   //Guardo la posicion final de la vble actual
                            $offset += $ending + 1; //Sumo desplazamiento para la proxima variable
                            $vb = substr($value, $begining, $ending - $begining);   //Guardo el valor de la variable
                            if (isset($var[$vb]))   $value = str_replace("%$vb%", $var[$vb], $value);   //Hago el reemplazo
                            else    $value = str_replace("%$vb%", $vb, $value);   //Hago el reemplazo
                        }
                        unset($vbles, $offset, $begining, $ending, $vb);
                        $result[$p][$key] = $value;
                    }
                    unset($key, $value);
                }
            }
        }
        if (isset($result)) return $result;
    }

    static function ucs2html($str) {
        $str=trim($str); // if you are reading from file
        $len=strlen($str);
        $html='';
        for($i=0;$i<$len;$i+=2)
            $html.='&#'.hexdec(dechex(ord($str[$i+1])).sprintf("%02s", dechex(ord($str[$i])))).';';
        return($html);
    }

    static function selfURL() {
        $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
        $protocol = self::strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
        return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
    }

    static function strleft($s1, $s2) {
        return substr($s1, 0, strpos($s1, $s2));
    }

} ?>