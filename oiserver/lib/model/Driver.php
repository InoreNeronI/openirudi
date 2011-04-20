<?php

/**
 * Subclass for representing a row from the 'driver' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Driver extends BaseDriver {
    
    static function listFiles($from = '.') {
        if (!is_dir($from)) return false;
        $files = array();
        if ($dh = opendir($from)) {
            while (false !== ($file = readdir($dh))) {
                // Skip '.' and '..'
                if ($file == '.' || $file == '..')  continue;
                $path = $from . '/' . $file;
                if (is_dir($path))  $files = array_merge($files, self::listFiles($path));
                else    $files[] = $path;
            }
            closedir($dh);
        }
        return $files;
    }
    
    static function returnSearch($driver) {
        if (!is_null($driver)) {
            $c = new Criteria;
            $c->add(PathPeer::DRIVER_ID, $driver->getId());
            $path = PathPeer::doSelectOne($c);
            if (!is_null($path)) {
                // increase script timeout value
                ini_set('max_execution_time', 300);
                // create object
                $zip = new ZipArchive();
                $filename = "/tmp/newzip.zip";
                if (is_file($filename)) unlink($filename);
                // open archive
                if ($zip->open($filename, ZIPARCHIVE::CREATE) !== TRUE) {
                    exit("cannot open <$filename>\n");
                }
                $files = Driver::listFiles($path->getPath());
                //require (sfConfig::get('app_const_root_dir')."/apps/backend/lib/zipfile.php");
                //$dr_timestamp = self::getStamp();
                foreach ($files as $file) {
                    //$zip->addFile($file, str_replace($path->getPath().'/', $dr_timestamp.'/', $file));
                    $zip->addFile($file, str_replace($path->getPath().'/', md5($path->getPath()).'/', $file));
                }
                //unset($dr_timestamp);
                $zip->close();
                ////// Mandar fichero al navegador
                $filedatatype = 'application/octet-stream';
                $filesize = filesize($filename);
                header("Pragma: public");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Cache-Control: private",false);
                header("Content-Type: $filedatatype");
                header("Content-Disposition: attachment; filename=\"".$filename."\";");
                header("Content-Transfer-Encoding:­ binary");
                header("Content-Length: ".$filesize);
                readfile($filename);
            }
        }
        exit;
    }

    static function getStamp() {
        $now = (string)microtime();
        $now = explode(' ', $now);
        $mm = explode('.', $now[0]);
        $mm = $mm[1];
        $now = $now[1];
        $segundos = $now % 60;
        $segundos = $segundos < 10 ? "$segundos" : $segundos;
        return strval(date("YmdHi",mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))) . "$segundos$mm");
    }
    
    function __toString() {
        if($this->name)
            return $this->name;
        else
            return 'NULL';
    }

//    function getTypeLink() {
//        return link_to($this->getType()->getType(), 'type/edit?id='.$this->getTypeId());
//    }
	//kam
	public function getDevice(PropelPDO $con = null)
	{
		if ($this->aDevice === null && (($this->device_id !== "" && $this->device_id !== null))) {
			$c = new Criteria(DevicePeer::DATABASE_NAME);
			$c->add(DevicePeer::CODE, $this->device_id);
			//kam
			//OHARRA::::device bat code-rekin bakarra ez da bereizten	
			$c->add(DevicePeer::VENDOR_ID,$this->vendor_id);
			$c->add(DevicePeer::TYPE_ID,$this->type_id);
			//
			$this->aDevice = DevicePeer::doSelectOne($c, $con);
			
		}
		return $this->aDevice;
	}
	//kam
	public function getVendor(PropelPDO $con = null)
	{
		if ($this->aVendor === null && (($this->vendor_id !== "" && $this->vendor_id !== null))) {
			$c = new Criteria(VendorPeer::DATABASE_NAME);
			$c->add(VendorPeer::CODE, $this->vendor_id);
			//kam
			//OHARRA::::vendor bat ez da code-rekin bakarra bereizten
			$c->add(VendorPeer::TYPE_ID, $this->type_id);
			//
			$this->aVendor = VendorPeer::doSelectOne($c, $con);
			
		}
		return $this->aVendor;
	}	
}
