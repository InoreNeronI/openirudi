<?php
define('ROOT','/oiImages/' );
define('PREFIX', 'oiImage_');

if(isset($_REQUEST['id'])){
   $fileName=ROOT.'/'.PREFIX.$_REQUEST['id'].".info";
   echo "<br>fileName:: $fileName";
    if(is_file($fileName)){
        echo "<br>1111111<br>";
        $info=parse_ini_file($fileName);
        echo "<br>info:: ".print_r($info,1)."---------<br>";
    }else{
        echo "<br>222222<br>";
        $info=array();
    }
}else{
    echo "<br>3333<br>";
    $info=array();
}
$out=base64_encode(serialize($info));
echo "!@@@$out!@@@";



?>
