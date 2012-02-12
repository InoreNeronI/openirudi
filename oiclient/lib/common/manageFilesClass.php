<?php

class manageFilesClass {

    private $handle;
    private $file;

    function __construct($file) {
        $this->file = $file;
    }

    function openFile($mode) {
        if (!$this->handle = fopen($this->file, $mode)) {
            exceptionHandlerClass::saveError("Error writing file");
            return false;
        }
    }

    function closeFile() {
        return fclose($this->handle);
    }

    function readStrFile() {
        $this->openFile($mode);
        $contents = fread($this->handle, filesize($this->file));
        return $contents;
    }

    function readArrayFile() {
        $contents = file($this->file);
        return $contents;
    }

    function writeFile($content, $mode) {
        $this->openFile($mode);
        if (fwrite($this->handle, $content) === FALSE) {
            exceptionHandlerClass::saveError("Cannot write to file");
            return false;
        }
        return true;
    }

    static function caseInsensibleFileName($file) {
        $path_parts = pathinfo($file);
        $pathDirs = split('/', $path_parts['dirname']);
        $rDir = "";
        foreach ($pathDirs as $pdir) {
            if (empty($pdir))
                continue;
            $p1 = glob("$rDir/*");
            $cont = false;
            foreach ($p1 as $k => $v) {
                
                if (strcasecmp("{$rDir}/{$pdir}", $v)==0) {
                    $rDir.='/' . basename($v);
                    $rDir = str_replace('//', '/', $rDir);
                    $cont = true;
                    break;
                }
            }
            if (!$cont) {
                return false;
            }
        }
        $p1 = glob("$rDir/*");

        $f = array();
        foreach ($p1 as $k => $v) {
            if (stristr("{$rDir}/{$path_parts['basename']}", $v)) {
                $f[filesize($rDir . '/' . basename($v))] = $rDir . '/' . basename($v);
            }
        }
        return array_pop($f);
    }

}

?>