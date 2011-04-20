<?php

class Catalogue extends BaseCatalogue
{
	public function __toString(){
		return $this->name;
	}
	public function save(PropelPDO $con = null)
	{
		$time=time();
		if($this->isNew()){
			$this->setDateCreated($time);
		}else{		
			$this->setDateModified($time);
		}
		$this->setAuthor(sfContext::getInstance()->getUser()->getGuardUser()->getUsername());
		
		$this->remove_cache();

		return parent::save($con);   
	}
	public function delete(PropelPDO $con = null)
	{
		$this->remove_cache();

		return parent::delete($con);	
	}
	private function remove_cache(){
		$cache_dir=sfConfig::get('sf_app_cache_dir');				
		$my_cache=new sfFileCache(array('cache_dir'=>$cache_dir));
		$my_cache->clean();
	}
}
