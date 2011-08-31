<?php
class manageFilesClass {
	private $handle;
	private $file;
	
	function __construct($file){
		$this->file=$file;
	}

	
	function openFile($mode){
		if (!$this->handle = fopen($this->file, $mode)) {
			exceptionHandlerClass::saveError("Error writing file");
			return false;
		}
	}
	
	function closeFile(){
		return fclose($this->handle);
	}
	
	
	function readStrFile(){
		$this->openFile($mode);
		$contents = fread($this->handle, filesize($this->file));
		return $contents;
	}
	
	function readArrayFile(){
		$contents= file($this->file);
		return $contents;
	}
	
	function writeFile($content, $mode){
		$this->openFile($mode);
		if (fwrite($this->handle, $content) === FALSE) {
			exceptionHandlerClass::saveError("Cannot write to file");
			return false;
		}
		return true;
	}
	
}

?>