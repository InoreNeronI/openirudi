<?php
require_once ('pendingTask.php');

# Get MAC address
$mac = strtoupper(str_replace(':','',$_GET['mac']));

# Prompt message:
$prompt_message = "Sakatu F10 Openirudi-ra sartzeko edo itxaron 5 segundu...";
# Prompt timeout:
$prompt_timeout = "5000";

$clientParams=clientParams();
$t=pendingTask($mac);

?>
#!gpxe

<? if (isset($mac) && !pendingTask($mac)){

        # Limpiando la pantalla...
        for ($i=0; $i<50; $i++){
                echo "echo \n";
        }
?>

# Press F10 (5 sec)
<?php echo "echo $prompt_message \n"; ?>
echo
echo
echo
prompt --key 0x167e --timeout <?=$prompt_timeout?> ... && goto openirudi || goto localboot

<?
   }else{
?>

goto openirudi

<?
}
?>


:openirudi
echo Booting Openirudi
imgfree
kernel -n openirudi http://<?=$clientParams['server'];?>/oiserver/web/func/root/boot/bzImage
initrd http://<?=$clientParams['server'];?>/oiserver/web/func/root/boot/rootfs.gz

imgargs openirudi rw root=/dev/null vga=normal screen=800x600x24 lang=es_ES kmap=es sound=noconf user=root user=root autologin server=<?= $clientParams['server']; ?> password=<?= $clientParams['password']; ?> type=<?= $clientParams['type']; ?> ip=<?= $clientParams['ip']; ?> netmask=<?= $clientParams['netmask']; ?> gateway=<?= $clientParams['gateway']; ?> dns1=<?= $clientParams['dns1']; ?> dns2=<?= $clientParams['dns2']."\n"; ?>


boot openirudi


:localboot
echo Booting from local disk
set 209:string http://<?=$clientParams['server'];?>/oiserver/web/func/root/pxelinux.cfg/default
set 210:string http://<?=$clientParams['server'];?>/oiserver/web/func/root/pxelinux.cfg/
chain http://<?=$clientParams['server'];?>/oiserver/web/func/root/pxelinux.0
