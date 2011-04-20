<?php
//gemini
$size = 100; // Diskoaren neurria
//
$container_size = 500; // div nagusiaren neurria (px)
//gemini
$my_action=$sf_request->getParameter('action');
//

// $colors = array('#FF0000', '#00FF00', '#0000FF', '#0066FF', '#009999 ', '#00CC33 ', '#00CCFF', '#00FF99 ', '#330033 ', '#3300FF', '#333399 ', '#336633 ', '#3366FF', '#339999 ', '#33CC33 ', '#33CCFF', '#33FF99 ', '#660033 ', '#6600FF', '#663399 ', '#666633 ', '#6666FF', '#669999 ', '#66CC33 ', '#66CCFF', '#66FF99 ', '#990033 ', '#9900FF', '#993399 ', '#996633 ', '#9966FF', '#999999 ', '#99CC33 ', '#99CCFF', '#99FF99 ', '#CC0033 ', '#CC00FF', '#CC3399 ', '#CC6633 ', '#CC66FF', '#CC9999 ', '#CCCC33 ', '#CCCCFF', '#CCFF99 ', '#FF0033 ', '#FF00FF', '#FF3399 ', '#FF6633 ', '#FF66FF', '#FF9999 ', '#FFCC33 ', '#FFCCFF', '#FFFF99 ');
$colors = array('#FF0000', '#4D79FF', '#FFFF00', '#794DFF', '#D24DFF', '#4DD2FF', '#FF4D79', '#4DFFD2', '#D19D00', '#FFC30F', '#FF794D', '#4DFF79', '#D2FF4D', '#FFD24D');

//gemini
//$colors=sfConfig::get('app_imageset_colors');
//

//gemini
//OHARRA::::<td class="id" lerroan ID-a batetik hasteko
//$numbers = range(0, 100);
$numbers = range(1, 100);
//

// aurretik datozen partizioak
//gemini
/*
$pp = array(
  array('id' => 0, 'name' => 'Bat', 'size' => 300, 'type' => 3, 'locked' => 0),
  array('id' => 1, 'name' => 'Bi', 'size' => 200, 'type' => 1, 'locked' => 0),
  array('id' => 2, 'name' => 'Hiru', 'size' => 500, 'type' => 2, 'locked' => 0)
);
*/
//gemini
if(count($pp)>0){
//
	foreach($pp as $k => $v){
	  //gemini
	  /*$pp[$k]['color'] = array_shift($colors);
	  array_shift($numbers);*/	  
	  array_shift($numbers);
	  if(empty($pp[$k]['color'])){
		$my_color=array_shift($colors);
		$pp[$k]['color']=$my_color;
	  }else{
		$colors=unset_color($pp[$k]['color'],$colors);
	  }		
   }
}

//gemini
//$pp=set_pp_color($pp,$colors)
//

// partizio motak
//gemini
/*
$mm = array(
  array('id' => 0, 'izen' => 'Undefined', 'ikono' => ''),
  array('id' => 1, 'izen' => 'Ubuntu', 'ikono' => ''),
  array('id' => 2, 'izen' => 'Debian', 'ikono' => ''),
  array('id' => 3, 'izen' => 'Windows XP', 'ikono' => ''),
  array('id' => 4, 'izen' => 'MacOS', 'ikono' => ''),
  array('id' => 5, 'izen' => 'Windows 7', 'ikono' => ''),
);
*/

// mezuak
$msg = array(
  'tamaina_gainditu' => __('Allocated partition size exceeds available disk space'),
  'aurrera_konfirmatu' => __('The disk will be erased. Are you sure?'),
  'azkena_ezin_ezabatu' => __('We need a partition at least'),
  'ezabatu_konfirmatu' => __('This partition will be deleted. Are you sure?'),
  //gemini
  'izena_hutsa' => __('Name is empty')		
);

?>
<!--gemini
<!DOCTYPE html>
<html>
<head>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
-->
  <style type="text/css">
    .resizable { width: 100px; height: 100px; background: silver; position:absolute; text-align: right; padding:2px;}
  </style>
  <script>
  <?php 
  print 'var pp = ' .json_encode($pp) .";\n";
  print 'var colors = ' .json_encode($colors) .";\n";
  print 'var numbers = ' .json_encode($numbers) .";\n";
  print 'var msg = ' .json_encode($msg) .";\n";
  print "var container_size = $container_size;\n";
  print "var size = $size;\n";
  //gemini
  print "var my_action = '".$my_action."'\n";
  //	
  ?>
  $(document).ready(function() {
	
	if(my_action!="show"){
    	doResizable();
	}
    // doLockable();
    doActivateInputs();	
    doActivateDeleteButtons();
    updateTotal();

    // grafikoko divak aktibatu
    function doResizable(){
      $(".resizable").resizable();
      $(".resizable").resizable( "option", "maxHeight", 100 );
      $(".resizable").resizable( "option", "minHeight", 100 );
      limitResizeHandlers();
      $(".resizable").resizable({
	resize: function(event, ui) {
	  updateSizes();
	},
	stop: function(event, ui){
	  updateSizes();
	  limitResizeHandlers();
	}
      });
    }
    // grafikoko mugimendua mugatu, aurreko eta ondorengo partizioaren arabera
    function limitResizeHandlers(){
      // var str = "";
      $("#disk div.resizable").each(function(index, element){
	var min = $(element).next().width() == undefined ? 0 : $(element).next().width();
	$("#disk div.resizable:eq("+index+")").resizable("option", "minWidth", min);
	var max = $(element).prev().width() == undefined ? 500 : $(element).prev().width();
	$("#disk div.resizable:eq("+index+")").resizable("option", "maxWidth", max);
	// str += "index: "+index+", min: "+min+", max: "+max+"\n"; // +", name: " + $("#disk div.resizable:eq("+index+")").html()
      });
      // alert(str);
    }

    // partizioa ezabatzeko esteka aktibatu
    function doActivateDeleteButtons(id){
      var selector = id == undefined ? ".delete" : ".delete:eq("+id+")";
      $(selector).click(function(){
	var id = $(this).parent().parent().index(".partition");
	deletePartition(id);
	return false;
      });
    }	

    // taulako inputetako balioa aldatzean gainontzekoak eguneratu
    function doActivateInputs(id){
      var selector = id == undefined ? ".partition-size" : ".partition-size:eq("+id+")";
      $(selector).blur(function(){
	var id = $(this).parent().parent().index("tr.partition");
	pp[id].size = this.value;
	resizePartitionTable();
      });
    }

    // partizioaren tamaina finkatu, ez utzi aldatzen
    /*
    function doLockable(){
      $(".lock-partition").click(function(){
	var index = $(this).parent().parent().index("tr.partition");
	pp[index].lock = $(this).attr("checked");
      });
    }
    */

    // partizio berria erantsi zerrendan
    $("#add_new_partition").click(function(){
      addNewPartition();
    });

    // partizio berria erantsi zerrendan
    $("#execute").click(function(){
	  //gemini
	  if($('#imageset_name').val().length==0){
		alert(msg.izena_hutsa);
		return false;
	  }	
		
      var total = updateTotal();
      if(total > size){
	alert(msg.tamaina_gainditu);
	return false;
      } else {
	return confirm(msg.aurrera_konfirmatu);
      }
    });

    // ezabatu edo neurriz aldatutako partizio baten diferentzia kendu edo eransten dio hurrengo edo aurrekoari
    function assignToNext(id, diff){
      var target = pp[id+1] == undefined ? id-1 : id+1;
      pp[target].size = pp[target].size + diff;
    }

    // partizioetan jasotako tamainak aldatu, grafikoko eragiketei erantzunez
    function updateSizes(){
      var prev_width = 0;
      for(var i in pp){
	var w = parseInt($("#col-"+i).css("width")) - prev_width;
	prev_width += w;
	newSize = pix2Gb(w);
	pp[i].size = newSize;
	$("tr.partition:eq("+i+") td.tamaina input").val(newSize);
      };
      updateTotal();
    }

    function updateTotal(){
      var total = 0;
      for(var i in pp){
	total += pp[i].size;
      }
	  //alert(total+"="+size);
      //gemini
	  //var content = total > size ? '<span style="color:red">'+total.toFixed(2)+'%</span>' : total.toFixed(2);
	  var content = total > size ? '<span style="color:red">'+total.toFixed(2)+'%</span>' : total.toFixed(2)+'%';
      $("#free").html((size-total).toFixed(2)+"%");
      $("#total").html(content);
      return total;
    }

    // partizio bat ezabatu
    function deletePartition(id){
      // partizio bakarra gelditzen bada, ez ezabatu
      if(pp.length == 1){
	alert(msg.azkena_ezin_ezabatu);
	return;
      } else {
	if(!confirm(msg.ezabatu_konfirmatu)){
	  return;
	}
      }
      // ezabatutako partizioaren tamaina hurrengoari erantsi
      var n = id; // zenbaki bezala erabiltzeko
      var next = pp[n+1] == undefined ? (n == 0 ? pp.length : 0) : n+1;
      pp[next].size += parseInt($("tr.partition:eq("+id+") td.tamaina input").val());
      //// alert("id: "+id+", next: "+next+", add: "+pp[next].size);
      $("tr.partition:eq("+next+") td.tamaina input").val(pp[next].size);
      // datuetatik ezabatu
      pp.splice(n,1);
      // taulako lerroa ezabatu
      $("#partition-table tr.partition:eq("+id+")").remove();
      // grafikoa berregin
      resizePartitionTable();
    }

    // partizio bat bitan banatu
    function addNewPartition(){
      var newColor = colors.shift();// colors[newId];
      var newId = numbers.shift();// colors[newId];
      var newWidth = 5; // gutxieneko tamaina?
     
	  $("#partition-table tr.partition:last").after("<tr class=\"partition\">"+$("#partition-table tr.partition:last").html()+"</tr>");
	  
	  $("#partition-table tr.partition:last .id").css("background-color", newColor);
	  //gemini
	  $("#partition-table tr.partition:last .my_partition_color").val(newColor);	
	  //	
      $("#partition-table tr.partition:last .id").html(newId);
      pp.push({id:newId, color:newColor, name:newId, size:newWidth, type:0})
      resizePartitionTable();
      // aktibatu erantsi berria den lerroa
      var lastRowIndex = pp.length-1;
      doActivateInputs(lastRowIndex);
      doActivateDeleteButtons(lastRowIndex);
    }

    // grafikoa eguneratu
    function resizePartitionTable(){
      var add;
      var divWidth = 0;
      var html = "";
      for(var i in pp){
	add = (pp[i].size * container_size) / size;
	divWidth += add;
	html = '<div id="col-'+i+'" class="resizable" style="background-color:'+pp[i].color+';width:'+divWidth+'px;">'+pp[i].name+'</div>'+html;
      }
      $("#disk").html(html);
      doResizable();
      updateSizes();
    }

    // pixel tamaina disko tamainara bihurtu
    function pix2Gb(pix){
      return (pix*size)/container_size;
    }
    // disko tamaina pixel tamainara bihurtu
    function gb2pix(gb){
      return (gb*container_size)/size;
    }

  });
  </script>
<!--gemini
</head>
<body style="font-size:62.5%;">
-->
<?php

$div_margin = 0;
//gemini
$div_width=0;
$output='';
$divs=array();
//
foreach($pp as $k => $p){
  $div_add = ($p['size'] * $container_size) / $size;
  $div_width += $div_add;
  $divs[] = '<div id="col-'.$k.'" class="resizable" style="background-color:'.$p['color'].';width:'.$div_width.'px;">'.$p['name'].'</div>';
}
$output .= '<div id="disk" style="width:'.($container_size+4).'px; height: 104px; border:1px solid black; position:relative; background-color:#000000;">'. join(array_reverse($divs), ''). '</div>';

//gemini
//$output .= '<div style="position:absolute; top:120px">';
//$output .= '<div style="position:relative; top:10px;padding-bottom:120px;">';
$output .= '<div style="position:relative; top:10px;">';
//
$output .= '<h3 style="position:relative">'.__('Partitions').'</h3>';
//gemini
//$output .= '<form method="POST">';
//$output .= partition_table(array('partitions' => $pp));
$output .= partition_table(array('partitions' => $pp),$mm,$my_action);
//

//gemini
/*
$output .= '<input id="add_new_partition" type="button" name="add_new" value="'.__('Add new partition').'" />';
$output .= '<input id="execute" type="submit" name="repart" value="'.__('Execute').'" />';
$output .= '</form>';
*/

//gemini
if($my_action=='show'){
	$output.=get_partial('show_actions', array('imageset' => $imageset, 'configuration' => $configuration, 'helper' => $helper));  	
}else{
	$output.=get_partial('imageset/form_actions', array('imageset' => $imageset, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ;	
}

$output .= '</div>';

print $output;

//gemini
//OHARRA:::: $mm parametro bezala
//function select_type($zein = 0){
function select_type($mm,$zein = 0){
  //gemini	
  //global $mm;
  $options = array();
  foreach($mm as $k => $m){
    $selected = $zein == $m['id'] ? ' selected="selected"' : '';
    $options[] = '<option value="'.$m['id'].'" '.$selected.'>'.$m['izen'].'</option>';
  }
  $output = '<select name="type[]">'. join($options, '') .'</select>';
  return $output;
}

//gemini
//OHARRA::::$mm parametro bezala
function partition_table($settings,$mm,$my_action){
  $output = '';

  $rows = array();
  $pp = $settings['partitions'];
  foreach($pp as $k => $p){
	$my_name='';
	if(!empty($p['name'])){
		$my_name=$p['name'];
	}
	//gemini
	if($my_action=='show'){
		/*$rows[] =  '<tr class="partition">
		  <td class="id" style="background-color:'.$p['color'].'">'.($k+1).'</td>
		  <td class="izen">'.$my_name.'</td>
		  <td>'.$p['type_name'].'</td>
		  <td class="tamaina">'.$p['size'].' GB.</td>
		  <td>&nbsp;</td>
		</tr>';*/
		//OHARRA::::name ez da behar partizioetan
		$rows[] =  '<tr class="partition">
		  <td class="id" style="background-color:'.$p['color'].'">'.($k+1).'</td>		  
		  <td>'.$p['type_name'].'</td>
		  <td class="tamaina">'.$p['size'].' %</td>
		  <td>&nbsp;</td>
		</tr>';
	}else{
		//gemini
		//OHARRA::::<td class="id" lerroan ID-a batetik hasteko  ($k+1) gehitu da
		// 
		/*$rows[] =  '<tr class="partition"><input type="hidden" class="my_partition_color" name="partition_colors[]" value="'.$p['color'].'"/>
		  <td class="id" style="background-color:'.$p['color'].'">'.($k+1).'</td>
		  <td class="izen"><input type="textfield" name="partition_names[]" value="'.$my_name.'" size="5" /></td>
		  <td>'.select_type($mm,$p['type']).'</td>
		  <td class="tamaina"><input class="partition-size" type="textfield" name="partition_sizes[]" value="'.$p['size'].'" size="5" /> %</td>
		  <td><input type="button" class="delete" value="'.__('Delete').'" /></td>
		</tr>';*/
		/*OHARRA::::name ez da behar partizioetan baino editatzerakoan hidden bezela pasa, nahiz ta kasurik
		ez egin edo hutsa izan , baino seguruna javascript erroreak ekidingo dira*/
		$rows[] =  '<tr class="partition"><input type="hidden" class="my_partition_color" name="partition_colors[]" value="'.$p['color'].'"/>
		  <td class="id" style="background-color:'.$p['color'].'">'.($k+1).'</td>
		  <input type="hidden" name="partition_names[]" value="'.$my_name.'"/>
		  <td>'.select_type($mm,$p['type']).'</td>
		  <td class="tamaina"><input class="partition-size" type="textfield" name="partition_sizes[]" value="'.$p['size'].'" size="5" /> %</td>
		  <td><input type="button" class="delete" value="'.__('Delete').'" /></td>
		</tr>';
	}
  }

  //gemini
  //OHARRA:::: name ez erakutsi
  /*$output .= '
  <table id="partition-table"><tbody>
  <tr><th>'.__('ID').'</th><th>'.__('Name').'</th><th>'.__('Type').'</th><th>'.__('Size').'</th><th></th></tr>
  '.join($rows, '').'
  <tr><th></th><th></th><th>'.__('Free').'</th><th id="free"></th><th></th></tr>
  <tr><th></th><th></th><th>'.__('Total').'</th><th id="total"></th><th></th></tr>
  </tbody></table>';*/

  $output .= '
  <table id="partition-table"><tbody>
  <tr><th>'.__('ID').'</th><th>'.__('Type').'</th><th>'.__('Size').'</th><th></th></tr>
  '.join($rows, '').'
  <tr><th></th><th></th><th>'.__('Free').'</th><th id="free"></th><th></th></tr>
  <tr><th></th><th></th><th>'.__('Total').'</th><th id="total"></th><th></th></tr>
  </tbody></table>';

  return $output;
}
//gemini
/*
function __($text){
  return $text;
}
*/
//gemini
function set_pp_color($pp,$colors){
	$result=$pp;
	if(count($result)>0){
		$kont=0;
		foreach($result as $i=>$row){
			$result[$i]['color']=$colors[$kont];
			$kont++;
		}
	}
	return $result;
}
//gemini
function unset_color($c,$colors){
	$result=array();

	if(count($colors)){
		foreach($colors as $i=>$value){
			if($c!=$value){
				$result[]=$value;
			}
		}
	}

	return $result;
}
?>
<!--gemini
</body>
</html>
-->