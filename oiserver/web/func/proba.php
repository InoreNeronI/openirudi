<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 function create_out_params(){
       $params=array('ref'=>'9999','name'=>'berria','description'=>'kaixo','so'=>'windows','partition_size'=>123,'filesystem_size'=>876,'path'=>'/var/www/betikoa');
       $myArray=array();
       foreach($params as $name=>$value){
            $myArray[]=$name.'='.$value;
       }
       $cfg=join('#',$myArray);
       $cfg=base64_encode($cfg);
       return $cfg;
    }
?>
<a href="./out_insert.php?out_params=<?php echo create_out_params();?>">out_insert</a>