#!/bin/sh


whichGrub(){
    if [ $# -ne 2 ]; then
        echo "ERROR: Wrong argument number: error $0 whichGrub [mountPoint] ";
        exit 1
    fi

    if [ -f "${2}/boot/grub/grub.cfg" ]
    then
        echo "GRUB197"
    elif [ -f "${2}/boot/grub/menu.lst" ]
    then
        echo "GRUB097"
    else
        echo "Uknown"
    fi

}

grubStandalone(){
    if [ $# -ne 2 ]; then
        echo "ERROR: Wrong argument number: error $0 grubStandalone [mountPoint]";
        exit 1
    fi

    GRUB=$(whichGrub whichGrub ${2} )

    case "${GRUB}" in
        "GRUB197")
            standalone1_97 standalone1_97 ${2}
            ;;
        "GRUB097")
            standalone0_97 standalone0_97 ${2}
            ;;
        *)
            echo "Unknown Grub: $GRUB"
            exit 1
    esac;
}

standalone0_97(){
    if [ $# -ne 2 ]; then
        echo "ERROR: Wrong argument number: error $0 standalone0_97 [mountPoint]";
        exit 1
    fi

    PARTITION=$(mount |grep ${2}|awk '{print $1}'|awk '{FS="/"; print $3}')

    LINUXPARTITIONNUM=$(echo ${PARTITION}|sed 's/[a-zA-Z\/]\{1,\}//')
    GRUB_PARTITION=$(expr $LINUXPARTITIONNUM - 1)
    LINUXDISK=$(echo ${PARTITION}|sed 's/[0-9]\{1,\}//')
    LINUXDISKLETTER=$(echo $LINUXDISK|sed 's/[a-zA-Z]\{1,2\}//')

    GRUB_DISK=0
    for i in a b c d e f g h i j k l m n o p q r s t x y z -
    do
            if ( [ $i == $LINUXDISKLETTER ] )
            then
                    break;
            fi
            GRUB_DISK=$(expr $GRUB_DISK + 1 )
    done

    INSTALL=0
    MKCONFIG=$(chroot ${2} which grub-mkconfig)
    if [ -n "${MKCONFIG}" ]
    then
        chroot ${2} grub-mkconfig -o /boot/grub/menu.lst
        INSTALL=1
    elif [ -f "${2}/boot/grub/menu.lst" ] && [ -n "${PARTITION}" ]
    then
        sed -i "s/root=[\/a-zA-Z0-9\=]*/root=\/dev\/${PARTITION}/g" "${2}/boot/grub/menu.lst"
        sed -i "s/root ([a-zA-Z0-9,]*) */root (hd${GRUB_DISK},${GRUB_PARTITION})/g" "${2}/boot/grub/menu.lst"
        INSTALL=1
    fi

    if [ ${INSTALL}=1 ]
    then
        mount -o remount,dev ${2}
        mount -t proc none /${2}/proc
        mount -o bind /sys /${2}/sys
        mount -o bind /dev/pts ${2}/dev/pts
        echo -e "root (hd${GRUB_DISK},${GRUB_PARTITION})\nsetup (hd${GRUB_DISK})"
        echo -e "root (hd${GRUB_DISK},${GRUB_PARTITION})\nsetup (hd${GRUB_DISK})" |chroot ${2} $(chroot ${2} which grub) --batch
        umount ${2}/dev/pts
        umount ${2}/sys
        umount ${2}/proc
   else
        echo "ERROR we can fix MBR and boot menu"
        exit 1
   fi


}

standalone1_97(){

    if [ $# -ne 2 ]; then
        echo "ERROR: Wrong argument number: error $0 standalone1_97 [mountPoint]";
        exit 1
    fi


    PARTITION=$(mount |grep ${2}|awk '{print $1}'|awk '{FS="/"; print $3}')

    LINUXPARTITIONNUM=$(echo ${PARTITION}|sed 's/[a-zA-Z\/]\{1,\}//')
    GRUB_PARTITION=$LINUXPARTITIONNUM
    LINUXDISK=$(echo ${PARTITION}|sed 's/[0-9]\{1,\}//')
    LINUXDISKLETTER=$(echo $LINUXDISK|sed 's/[a-zA-Z]\{1,2\}//')

    GRUB_DISK=0
    for i in a b c d e f g h i j k l m n o p q r s t x y z -
    do
            if ( [ $i == $LINUXDISKLETTER ] )
            then
                    break;
            fi
            GRUB_DISK=$(expr $GRUB_DISK + 1 )
    done
echo "----1-------"
    mount -o remount,dev ${2}
    mount -t proc none /${2}/proc
    mount -o bind /sys /${2}/sys
    mount -o bind /dev ${2}/dev
    mount -o bind /dev/pts ${2}/dev/pts
echo "----2-------"    
    
    INSTALL=0
    MKCONFIG=$(chroot ${2} which grub-mkconfig)

    if [ -n "${MKCONFIG}" ]
    then
        M=$(chroot ${2} ${MKCONFIG} -o /boot/grub/grub.cfg)
        INSTALL=1
    elif [ -f "${2}/boot/grub/grub.cfg" ] &&  [ -n "${PARTITION}" ]
    then
        sed -i "s/root=\/dev\/[a-zA-Z0-9]*/root=\/dev\/${PARTITION}/g" "${2}/boot/grub/grub.cfg"
        #sed -i "s/(hd[0-9]*/(hd${GRUB_DISK}/g" "${2}/boot/grub/grub.cfg"
        #sed -i "s/,[0-9]*)/,${GRUB_PARTITION})/g" "${2}/boot/grub/grub.cfg"
        sed -i "s/(hd[0-9]*,[0-9]*)/(hd${GRUB_DISK},${GRUB_PARTITION})/g" "${2}/boot/grub/grub.cfg"
        INSTALL=1
    fi

    if [ ${INSTALL}=1 ]
    then
echo "----3-------"
        echo "chroot ${2} $(which grub-install)  ${LINUXDISK} "
        chroot ${2} $(which grub-install)  /dev/${LINUXDISK}
echo "----4-------"
    else
        echo "ERROR we can't fix MBR and boot menu"
        exit 1
    fi

echo "----5-------" 

    umount ${2}/sys
    umount ${2}/dev/pts
    umount ${2}/proc
    umount ${2}/dev

}

setHostName(){

    if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number: error $0 setHostName [linuxPath] [newName]";
        exit 1
    fi

    HOSTNAME_FILE="${2}/etc/hostname"
    HOSTS_FILE="${2}/etc/hosts"

    OLDNAME=$( cat ${HOSTNAME_FILE} )

    echo "${3}" > ${HOSTNAME_FILE}
    A=$(cat ${HOSTS_FILE} | sed "s/${OLDNAME}/${3}/g" )
    echo -e "name ${A}" > ${HOSTS_FILE}

}

setNetworkManager(){

    if [ $# -ne 5 ] ; then
        echo "ERROR: Wrong argument number: error $0 [linuxPath] [ipAddress] [netmask] [gateway] [dns]";
        exit 1
    fi

    if [ ! -d ${1}/etc/NetworkManager  ]
    then
        echo "ERROR: we not found Network Manager"
        exit 1
    fi

    if [ -f ${1}/etc/NetworkManager/system-connections/openirudi ]
    then
        rm ${1}/etc/NetworkManager/system-connections/openirudi
    fi

    CONF="[connection]
id=openirudi
uuid=$(uuidgen)
type=802-3-ethernet
"

    if [ -z "$2" ]
    then
CONF="${CONF}
[ipv4]
method=auto
"
    else

    CONF="${CONF}
[ipv4]
method=manual
dns=${5};
addresses1=${2};${3};${4};
"
    fi

    CONF="${CONF}
[802-3-ethernet]
duplex=full

[ipv6]
method=ignore
"

    echo "${CONF}" > ${1}/etc/NetworkManager/system-connections/openirudi
    chmod 600 ${1}/etc/NetworkManager/system-connections/openirudi

}

setInterfaces(){

    if [ $# -ne 5 ] ; then
        echo "ERROR: Wrong argument number: error $0 [linuxPath] [ipAddress] [netmask] [gateway] [dns]";
        exit 1
    fi

    if [ ! -f ${1}/etc/network/interfaces ]
    then
        echo "ERROR: We not found interfaces"
        exit 1
    fi

    CONF=$(cat ${1}/etc/network/interfaces |tr -s "\n" "@"|sed 's/@iface/\niface/g'|sed "s/auto/\nauto/g" |sed "s/iface eth0[a-zA-Z0-9\-\ \t@?\*\_\,\#\.]*/-OI-/g"|sed 's/-OI-:[0-9]*/iface eth0/g' )

    if [ -z "$2"  ]
    then
      NIP="iface eth0 inet dhcp"

    else
      NIP="iface eth0 inet static @address ${2} @netmask ${3} @gateway ${4}"
      echo "nameserver ${5}" > ${1}/etc/resolv.conf
    fi

    CONF2=$(echo -e "${CONF}" |sed 's/-OI-/'"${NIP}"'/g'| tr -s "@" "\n")
    if [ $? -ne 0 ];
    then
	echo -e "ERROR: changing new ip"
	exit 1
    fi

    echo -e "${CONF2}" > ${1}/etc/network/interfaces
    if [ $? -ne 0 ];
    then
	echo -e "ERROR: changing interfaces file"
	exit 1
    fi

}

changeIPAddress(){

    if [ $# -lt 2  ] || [ $# -gt 6 ] ; then
        echo "ERROR: Wrong argument number: error $0 changeIPAddress [IPAddress] [linuxPath] [ipAddress] [netmask] [gateway] [dns]";
        exit 1
    fi

    if [ -d ${2}/etc/NetworkManager  ]
    then
        echo "use Network manager"
        R=$(setNetworkManager "${2}" "${3}" "${4}" "${5}" "${6}" )
        if [ $? -ne 0 ];
        then
            echo -e "ERROR: changing linux ip address with network manager"
            echo "R:: ${R}"
            exit 1
        fi

         echo "R:: ${R}"
        

    elif [ -f ${2}/etc/network/interfaces ]
    then
        echo "use Debian interfaces"
        R=$(setInterfaces "${2}" "${3}" "${4}" "${5}" "${6}" )
        if [ $? -ne 0 ];
        then
            echo -e "ERROR: changing linux ip address"
            echo "R:: ${R}"
            exit 1
        fi
       
    else
        echo "We cant change IP address"
        exit 1
    fi


}

case $1 in
   'whichGrub')
      whichGrub ${*}
      ;;
   'grubStandalone')
      grubStandalone ${*}
      ;;
   'setHostName')
      setHostName ${*}
      ;;
   'changeIPAddress')
      changeIPAddress ${*}
      ;;
  *)
   echo "Error:"  ${*};
   exit 1
esac;

