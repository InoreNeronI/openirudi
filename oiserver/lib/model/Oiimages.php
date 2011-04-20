<?php

class Oiimages extends BaseOiimages {

    //kam
    public function get_custom_created_at() {
        return OiimagesPeer::get_custom_format_date($this->getCreatedAt());
    }

    //
    //kam
    public function __toString() {
        return $this->name;
    }

    //
    //kam
    public function delete(PropelPDO $con = null) {
        $this->unlink_files();
        parent::delete($con);
    }

    //kam
    private function unlink_files() {
        $path = sfConfig::get('app_path_oiimage');
        exec("sudo ../bin/oiserver.sh deleteImage {$this->id} {$path}", $out, $result);
    }

    public function isOpenirudi() {
        if ($this->name == 'openirudi' && $this->os == 'oiSystem') {
            return 1;
        }
        return 0;
    }

}
