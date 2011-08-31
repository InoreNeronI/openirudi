#!/bin/sh

umountPartition(){

    mount | grep ${1}
    [ $? -ne 0 ] && : || umount ${1}

    mount | grep ${1}
    if ( ! [ $? -ne 0 ] )
    then
            echo "I can't umount ${1}"
            exit 1
    fi

}

whichCD(){
    for CD in $(cat /proc/sys/dev/cdrom/info | grep "drive name" | cut -f 3-6)
    do
        B=$(od -h -N 1 /dev/$CD 2>/dev/null )
        if [ $? -ne 0 ]
        then
            continue
        fi
   
        _NON_CD=/dev/${CD}
        mount -rt iso9660 $_NON_CD /mnt
        if [ -f "/mnt/boot/rootfs.gz" ]
        then
            umount /mnt
            break
        else
            _NON_CD=''
        fi
        umount /mnt
    done

}

installFromCD(){
    if [ -z "${_NON_CD}" ]
    then
        echo "No Openirudi CDROM found"
        exit 1
    fi

    mount | grep $_ORG_MOUNTPOINT
    # if not mounted, just mount
    [ $? -eq 0 ] && : || mount -rt iso9660 $_NON_CD $_ORG_MOUNTPOINT
    mount | grep $_ORG_MOUNTPOINT
    if ( ! [ $? -eq 0 ] )
    then
            echo "I can't mount cdrom"
            exit 1
    fi

    if ( ! [ -f $_ORG_MOUNTPOINT/boot/rootfs.gz ] )
    then
            echo "Is not valid CDROM"
            exit 1;
    fi

    cp  $_ORG_MOUNTPOINT/boot/rootfs.gz $_MOUNTPOINT/rootfs.gz

    cp  $_ORG_MOUNTPOINT/boot/bzImage $_MOUNTPOINT/bzImage

}

installFromServer(){

    echo "<br>";
    if ( [ -f /tmp/openirudi.iso ] )
    then
        rm /tmp/openirudi.iso
    fi
    if [ -z "${SERVER}" ]
    then
        echo "No valid Openirudi server"
        return
    fi
    echo "Download image from server" > /tmp/process

    R=$(wget -O /tmp/openirudi.iso "http://${SERVER}/oiserver/web/func/root/openirudi.iso" &> /dev/null )
    if ( [ $? -ne 0 ] || ! [ -f /tmp/openirudi.iso ])
    then
        echo "ERROR download new image from server"
        echo "is openirudi.iso file created on server?"

        #echo "${R}"
        return 1
    fi

    if ( ! [ -d /tmp/iso ] )
    then
        mkdir /tmp/iso
    fi
    mount -o loop /tmp/openirudi.iso /tmp/iso
    cp /tmp/iso/boot/rootfs.gz $_MOUNTPOINT/rootfs.gz
    cp /tmp/iso/boot/bzImage $_MOUNTPOINT/bzImage

    umount /tmp/iso


    echo "<br>";
}

###########################################################################
#
#      MAIN
#
##########################################################################



BINPWD="/var/www/openirudi/";


_ORG_MOUNTPOINT='/tmp/orgOI'
_MOUNTPOINT='/tmp/linux'


whichCD

KERNEL=vmlinuz-`uname -r`

if [ $# -ne 1  ] && [ $# -ne 2  ]; then
        echo "we expect: $0 (partition) [boot]"; 
        exit 1
fi

LINUXPARTITION=$(echo $1|sed 's/\/dev\///');
LINUXPARTITIONDEVICE="/dev/$LINUXPARTITION"

echo "1: ${1}  LINUXPARTITION ${LINUXPARTITION}  LINUXPARTITIONDEVICE ${LINUXPARTITIONDEVICE} "



if(! test -b $LINUXPARTITIONDEVICE )
then
	echo "/dev/$LINUXPARTITIONDEVICE is not block device"
	#exit 1;
fi

if ( [ $# -eq 2 ] && [ "${2}" = 'boot' ] )
then
        echo "ONLY BOOT"
	ONLYBOOT=1;
else
	ONLYBOOT=0;
fi


LINUXPARTITIONNUM=$(echo ${LINUXPARTITION}|sed 's/[a-zA-Z\/]\{1,\}//')
LINUXDISK=$(echo ${LINUXPARTITION}|sed 's/[0-9]\{1,\}//')


echo "LINUXPARTITIONNUM ${LINUXPARTITIONNUM} LINUXDISK ${LINUXDISK}"

if (! $(echo $LINUXPARTITIONNUM|egrep '^[0-9]{1,2}$'>/dev/null))
then
	echo wrong partition $LINUXPARTITIONNUM in $LINUXPARTITIONDEVICE
	exit 1;
fi


#preserve config
echo "Save configuration"
cp -p ${BINPWD}/cache/openirudi.yml /tmp/openirudi.yml
cp -p ${BINPWD}/lib/common/user_list.txt /tmp/user_list.txt

SERVER="$(cat ${BINPWD}/cache/openirudi.yml |grep imageServer | awk '{print $2}'| tr -d "'" )"

echo " LINUXPARTITION $LINUXPARTITION LINUXPARTITIONNUM $LINUXPARTITIONNUM  LINUXDISK $LINUXDISK SEVER $SERVER "

[ ! -d $_MOUNTPOINT ] && mkdir -p $_MOUNTPOINT
[ ! -d $_ORG_MOUNTPOINT ] && mkdir -p $_ORG_MOUNTPOINT


echo "mount $LINUXPARTITIONDEVICE $_MOUNTPOINT"

mount | grep $_MOUNTPOINT
[ $? -eq 0 ] && : || mount $LINUXPARTITIONDEVICE $_MOUNTPOINT



mount | grep $_MOUNTPOINT
if ( [ $? -ne 0 ] )
then
	echo "I can't mount linux partition"
	exit 1;
fi

cd $_MOUNTPOINT

if ( [ $ONLYBOOT -eq 0 ] )
then
        echo Install from SERVER.
        installFromServer
        if [ $? -eq 1 ] || [ ! -f $_MOUNTPOINT/rootfs.gz ]
        then
            echo Install from CDROM.
            installFromCD
        fi
        
        #execute cpio in chroot. First copy need lib in chroot
        mkdir  ${_MOUNTPOINT}/bin
        mkdir  ${_MOUNTPOINT}/lib

        cp /bin/cpio ${_MOUNTPOINT}/bin/
        cp /lib/libm.so.6 ${_MOUNTPOINT}/lib/
        cp /lib/libc.so.6 ${_MOUNTPOINT}/lib/
        cp /lib/ld-linux.so.2 ${_MOUNTPOINT}/lib/

echo "<br>Expand new filesystem";
        echo "Expand new filesystem" > /tmp/process

	(zcat rootfs.gz 2>/dev/null || lzma d rootfs.gz -so) | chroot ${_MOUNTPOINT} /bin/cpio -idu
        if ( [ $? -ne 0 ] )
        then
            echo "Error expanding root filesystem"
            exit 1;
        fi
echo "<br>New file system has been created"


	rm -f $_MOUNTPOINT/rootfs.gz

        cp /etc/sudoers ${_MOUNTPOINT}/etc/sudoers

        echo "copy kernel"
        mkdir -p "${_MOUNTPOINT}/boot/grub"

        mv ${_MOUNTPOINT}/bzImage ${_MOUNTPOINT}/boot/$KERNEL
        if ( [ $? -ne 0 ] )
        then
            echo "I move linux kernel file"
            exit 1;
        fi

fi

#preserve config
cp -p /tmp/openirudi.yml ${_MOUNTPOINT}/${BINPWD}/cache/openirudi.yml
cp -p /tmp/user_list.txt ${_MOUNTPOINT}/${BINPWD}/lib/common/user_list.txt

chown www:www ${_MOUNTPOINT}/${BINPWD}/cache/openirudi.yml
chmod 777 ${_MOUNTPOINT}/${BINPWD}/cache/openirudi.yml


echo "create /etc/fstab"
echo "
/dev/${LINUXPARTITION}	/	ext3	defaults 1 1
proc	/proc	proc	defaults	0	0
sysfs	/sys	sysfs	defaults	0	0
devpts	/dev/pts	devpts		defaults	0	0
tmpfs	/dev/shm	tmpfs		defaults	0	0
" > ${_MOUNTPOINT}/etc/fstab



if ( [ -f ${_MOUNTPOINT}/init ]  )
then
    rm ${_MOUNTPOINT}/init
fi


echo "install grub"


#remove OLD grub
echo "Remove old mbr"
dd if=/dev/zero of=/dev/${LINUXDISK} bs=446 count=1


grub-editenv ${_MOUNTPOINT}/boot/grub/grubenv create
grub-editenv ${_MOUNTPOINT}/boot/grub/grubenv set GRUB_DEFAULT=0
grub-editenv ${_MOUNTPOINT}/boot/grub/grubenv set GRUB_TIMEOUT=1

${BINPWD}/bin/slitazConfig.sh grubInstall ${LINUXDISK} ${_MOUNTPOINT}

cd -
umountPartition ${_MOUNTPOINT}
umountPartition ${_ORG_MOUNTPOINT}

echo -e "\n!!!OpenIrudi system has been installed successfully !!!"

echo "-" > /tmp/process


