<?php
define('ROOT','/oiImages/' );
define('PREFIX', 'oiImage_');

if(isset($_REQUEST['id'])){
   $fileName=ROOT.'/'.PREFIX.$_REQUEST['id'].".info";
    if(is_file($fileName)){
        $info=parse_ini_file($fileName);
    }else{
        $info=array();
    }
}else{
    $info=array();
}
$out=base64_encode(serialize($info));
echo "!@@@$out!@@@";



?>
