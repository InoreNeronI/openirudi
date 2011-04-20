<?php

/**
 * home actions.
 *
 * @package    drivers
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class homeActions extends sfActions {
	
    public function executeIndex(sfWebRequest $request) {
        if (!$request->getParameter('sf_culture')) {
            if ($this->getUser()->isFirstRequest()) {
                $culture = $request->getPreferredCulture(array('eu', 'es', 'en'));
                $this->getUser()->setCulture($culture);
                $this->getUser()->isFirstRequest(false);
            } else {
                $culture = $this->getUser()->getCulture();
            }
            //$this->kulture = $culture;

            $this->redirect('@localized_home');
        } //else  $this->kulture = $request->getParameter('sf_culture');
		
    }

    public function executeUpload() {
        if (is_file('/tmp/unzip_return.txt'))   unlink('/tmp/unzip_return.txt');
        if (isset($_FILES["Filedata"])) { // test if file was posted
            $orginal_file_name = strtolower(basename($_FILES["Filedata"]["name"])); //get lowercase filename
            $file_name = sha1($orginal_file_name."|".rand(0,99999));
            $file_ending = substr($orginal_file_name, strlen($orginal_file_name)-4, 4); //file extension

            if (in_array(strtolower($file_ending), array(".zip"), true)) { // file filter...
            // ...don't forget that file extension can be fake!

                $file = sfConfig::get('sf_upload_dir').'/'.$file_name.$file_ending;
                // path 'uploaded_data/' must exist! It's recommended that you store files with unique
                // names and not with original names.

                if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $file)) { // move posted file...
                    $new_driver = sfConfig::get('app_const_packs_root').'/Customs/'.$file_name;
                    exec("unzip -o $file -x -d ".$new_driver, $output, $ret_val);
                    if ($ret_val == 0) {
                        file_put_contents('/tmp/unzip_return.txt', $new_driver."\n");
                        foreach ($output as $line)  file_put_contents('/tmp/unzip_return.txt', trim($line)."\n", FILE_APPEND);
                    } else  file_put_contents('/tmp/unzip_return.txt', 'error', FILE_APPEND);
                        /*
                        TO-DO:
                        insert your PHP code to execute when file has been posted
                        */
                } else  file_put_contents('/tmp/unzip_return.txt', 'error', FILE_APPEND);
            } else  file_put_contents('/tmp/unzip_return.txt', 'error', FILE_APPEND);
        } else {
                /*
                TO-DO:
                insert your PHP code to execute when no file has been posted
                */
        }
        return sfView::NONE;
    }

    public function executeUploadEnd(sfWebRequest $request) {
        if (is_file('/tmp/unzip_return.txt')) {
            $this->getResponse()->setContentType('application/json');
            $content = file('/tmp/unzip_return.txt');
            unlink('/tmp/unzip_return.txt');
            foreach ($content as $k => $v)  $content[$k] = trim(str_replace("\n", '', $v));
            if (trim($content[0]) == 'error') {
                $path = 'null';
                $result = array('path' => $path, 'output' => $content[0]);
            } else {
                $path = $content[0];
                unset($content[0]);
                $result = array('path' => $path, 'output' => $content);
            }
            return $this->renderText(json_encode($result));
        }
    }
    
    public function executeOperate(sfWebRequest $request) {
        $this->getResponse()->setContentType('application/json');
        $path = $request->getParameter('path');
        $result = array('text' => ParseINF::operate($path));
        return $this->renderText(json_encode($result));
    }

    public function executeFilesParsed(sfWebRequest $request) {

    }

}