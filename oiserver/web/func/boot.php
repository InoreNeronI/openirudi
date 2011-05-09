<?
require_once ('/var/www/oiserver/web/func/pendingTask.php');

# Get MAC address
$mac = $_GET['mac'];

# Server name (http://server_name/boot/boot.php)
$server_name = $_SERVER['SERVER_NAME'];

# Prompt message:
$prompt_message = "Sakatu F10 Openirudi-ra sartzeko edo itxaron 10 segundu...";
# Prompt timeout:
$prompt_timeout = "10000";

?>
#!gpxe
# -----#ipxe

<? if (isset($mac) && !pendingTask($mac)){

        # Limpiando la pantalla...
        for ($i=0; $i<50; $i++){
                echo "echo \n";
        }
?>

# Press F10 (10 sec)
prompt --key 0x167e --timeout <?=$prompt_timeout?> <?=$prompt_message?> && goto openirudi || goto localboot

<?
   }
?>

:openirudi
echo Booting Openirudi
imgfree
kernel -n openirudi http://<?=$server_name?>/oiserver/web/func/root/boot/bzImage
initrd http://<?=$server_name?>/oiserver/web/func/root/boot/rootfs.gz

#root=/dev/null vga=normal screen=800x600x24 lang=es_ES kmap=es sound=noconf user=root autologin server=192.168.110.12 user=admin password=21232f297a57a5a743894a0e4a801fc3 type=dhcp ip= netmask= gateway= dns1= dns2=

imgargs openirudi rw root=/dev/null vga=normal screen=800x600x24 lang=es_ES kmap=es sound=noconf user=root autologin server=<?=$server_name?> user=admin password=21232f297a57a5a743894a0e4a801fc3 type=dhcp
boot openirudi

:localboot
echo Booting from local disk
set 209:string http://<?=$server_name?>/oiserver/web/func/root/pxelinux.cfg/default
set 210:string http://<?=$server_name?>/oiserver/web/func/root/pxelinux.cfg/
chain http://<?=$server_name?>/oiserver/web/func/root/pxelinux.0
