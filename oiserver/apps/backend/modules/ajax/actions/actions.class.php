<?php

/**
 * ajax actions.
 *
 * @package    drivers
 * @subpackage ajax
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class ajaxActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  
  //kam	
  /*public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }*/
  public function executeVendor(sfWebRequest $request)
    {
        $this->getResponse()->setContentType('application/json');

        $vendor_list = VendorPeer::get_autocomplete_vendor_list($request->getParameter('q'), $request->getParameter('limit'));

        $res = array();
        foreach($vendor_list as $v){     
			$code=$v->getCode();
			$res[$code] = $code;
		}

        return $this->renderText(json_encode($res));
    }
	public function executeDevice(sfWebRequest $request)
    {
        $this->getResponse()->setContentType('application/json');

        //OHARRA::::executeDevice ta executeDevice_id-n erabiltzen da
		$device_list = DevicePeer::get_autocomplete_device_list($request->getParameter('q'), $request->getParameter('limit'));

        $res = array();
        foreach($device_list as $d){     
			//$code=$d->getCode();
			//$res[$code] = $d->getName();
			$id=$d->getId();
			$res[$id]['id']=$id;
			$res[$id]['name']=$d->getName();
			$res[$id]['code']=$d->getCode();
			$res[$id]['vendor_id']=$d->getVendorId();
			$res[$id]['type_id']=$d->getTypeId();
		}

        return $this->renderText(json_encode($res));
    }
	public function executeDriver_name(sfWebRequest $request)
    {
        $this->getResponse()->setContentType('application/json');

        $driver_list = DriverPeer::get_autocomplete_driver_name_list($request->getParameter('q'), $request->getParameter('limit'));

        $res = array();
        foreach($driver_list as $d){     
			$name=$d->getName();
			$res[$name] = $name;
		}

        return $this->renderText(json_encode($res));
    }
	public function executeDevice_id(sfWebRequest $request)
    {
        $this->getResponse()->setContentType('application/json');

        //OHARRA::::executeDevice ta executeDevice_id-n erabiltzen da
		$device_list = DevicePeer::get_autocomplete_device_list($request->getParameter('q'), $request->getParameter('limit'));

        $res = array();
        foreach($device_list as $d){     
			$res[$d->getId()]=$d->getName();					
		}

        return $this->renderText(json_encode($res));
    }
	public function executePartition_list(sfWebRequest $request)
    {
        $this->getResponse()->setContentType('application/json');

		$pc_id=$request->getParameter('pc_id');

		$res = array();

		$res['partition']=array();
		$res['disk']=array();	

		if(!empty($pc_id)){
			$pc=PcPeer::retrieveByPk($pc_id);
			//gaur
			//$res=MyTaskPeer::form_partition_list_by_pc($pc);			
			$res['partition']=MyTaskPeer::form_partition_list_by_pc($pc);
			$res['disk']=MyTaskPeer::get_disk_list_by_partition_list($res['partition']);			
			//
		}
  
        return $this->renderText(json_encode($res));
    }		
}
