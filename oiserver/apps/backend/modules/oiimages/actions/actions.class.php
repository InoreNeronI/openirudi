<?php

require_once dirname(__FILE__).'/../lib/oiimagesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/oiimagesGeneratorHelper.class.php';

/**
 * oiimages actions.
 *
 * @package    drivers
 * @subpackage oiimages
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class oiimagesActions extends autoOiimagesActions
{
    public function executeBegizta_sortu(sfWebRequest $request){
        //$this->begizta_sortu();
    }
    private function begizta_sortu(){
        $num=100;
        for($i=1;$i<=100;$i++){
            $oiimages=new Oiimages();
            $oiimages->setRef('Ref'.$i);
            $oiimages->setName('Name'.$i);
            $oiimages->setDescription('Description'.$i);
            $oiimages->setSo('Linux'.$i);
            $oiimages->setCreatedAt(date("Y-m-d H:i:s"));
            $oiimages->setPartitionSize($i);
            $oiimages->setFilesystemSize(rand(0,1000));
            $oiimages->setPath("path".$i);
            $oiimages->save();
        }
    }
    public function executeView(sfWebRequest $request) {
        $this->oiimages = $this->getRoute()->getObject();
        $this->forward404Unless($this->oiimages);
    }
    public function executeIndex(sfWebRequest $request) {
		 //kam
		/*if (DriverPeer::is_no_query($this->getFilters()))
		{
		  $this->filters = $this->configuration->getFilterForm($this->getFilters());
		  $this->setTemplate('no_query');
		}else{*/
			//		
			$this->out_params=$this->create_out_params();
			parent::executeIndex($request);
		//}
    }
    private function create_out_params(){
       $params=array('ref'=>'9999','name'=>'berria','description'=>'kaixo','so'=>'windows','partition_size'=>123,'filesystem_size'=>876,'path'=>'betikoa');
       $myArray=array();
       foreach($params as $name=>$value){
            $myArray[]=$name.'='.$value;
       }
       $cfg=join('#',$myArray);
       $cfg=base64_encode($cfg);
       return $cfg;
    }
    
    /*public function executeOut_insert(sfWebRequest $request) {
     echo 'eooooooooooooooooo',exit();
     //$this->begizta_sortu();
    }*/
    public function executeDelete(sfWebRequest $request)
     {
         $oiimages=OiimagesPeer::retrieveByPk($request->getParameter('id'));
         if($oiimages->isOpenirudi()){
             $this->setTemplate('is_openirudi');
         }else{
             parent::executeDelete($request);
         }
     }

}
