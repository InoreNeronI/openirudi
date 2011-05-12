#!/bin/sh

update(){
    if [ $# -ne 4  ]; then
        echo "ERROR: Wrong argument number: error $0 update [url] [clientPath] [isoPath]";
        exit 1
    fi

    if [ ! -d ${3} ]
    then
        echo "ERROR no valid path for client"
        exit 1
    fi

    if [ ! -d ${4} ]
    then
        echo "ERROR no valid path for client iso"
        exit 1
    fi

    cd ${3}
    wget -O /tmp/last.tar "${2}"
    if [ $? != 0 ]
    then
        echo "ERROR downloading last client";
        exit 1;
    fi

    if [ -d ${3}/rootcd ]
    then
        rm -rf ${3}/rootcd
    fi

    cd ${3}
    echo "tar xvf /tmp/last.tar "
    tar -xvf  /tmp/last.tar
    if [ $? != 0 ]
    then
        echo "ERROR downloading last client";
        exit 1;
    fi

    if [ -f ${4}/openirudi.iso ]
    then
        rm -rf ${4}/openirudi.iso
    fi

}

getNetDevices(){
    if [ $# -ne 1  ]; then
        echo "ERROR: Wrong argument number: error $0 getNetDevices";
        exit 1
    fi

    DEVICES=$(cat /proc/net/dev |grep ':' |grep -v lo |cut -d ":" -f 1| tr -d " " )
    if [ $? != 0 ]
    then
      echo "ERROR listing network devices";
      exit 1;
    fi

    DEV=""
    for D1 in ${DEVICES}
    do
        IP=$(/sbin/ifconfig $D1 |grep "inet addr" |egrep 'addr:[0-9]+.[0-9]+.[0-9]+.[0-9]+' |tr -s "\n" ";"|sed 's/addr://g' |awk '{print $2}' )
        if [ $? != 0 ]
        then
          echo "ERROR listing network devices";
          exit 1;
        fi

        if [ -n "${D1}" ] && [ -n "${IP}" ]
        then
            DEV="${DEV}${D1};${IP};"
        fi
    done

    echo "!@@@$DEV!@@@"
}

deleteImage(){
    if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number: error $0 deleteImage [image_id] [path]";
        exit 1
    fi

    echo "ls ${3}/oiImage_${2}.f*"

    if [ -n "$(ls ${3}/oiImage_${2}.*)" ]
    then
        echo "rm ${3}oiImage_${2}.* DELETE"
        rm  ${3}/oiImage_${2}.*
    else
        echo "No files"
    fi
}

genOpenirudiIso(){
    if [ $# -lt 6  ] || [ $# -gt 12  ] || [ $1 != "genOpenirudiIso" ];
    then
# || [ $1!="genOpenirudiIso" ]; then
        echo "ERROR: Wrong argument number: error $0 genOpenirudiIso [rootcd_path] [iso_path] [server] [user] [password] [type] [ip] [netmask] [gateway] [dns1] [dns2]";
        exit 1
    fi

    MENU="
    default chain.c32 hd0 0
    "

    if [ -d "${2}" ] && [ -d "${3}" ];
    then
        cd "${2}"
        if ( ! [ $? -eq 0 ] )
        then
                echo "I can't cd to ${2}"
                exit 1
        fi
        echo -e "${MENU}" > boot/isolinux/isolinux.cfg



        $(which genisoimage) -R -o ${3}/openirudi.iso -b boot/isolinux/isolinux.bin -c boot/isolinux/boot.cat -no-emul-boot -boot-load-size 4 -V "openirudi" -input-charset iso8859-1 -boot-info-table .


        if [ "${7}" = 'dhcp' ]
        then
            if [ ! -d ${3}/boot ]
            then
                mkdir ${3}/boot
            fi
            if [ ! -d ${3}/pxelinux.cfg ]
            then
                mkdir ${3}/pxelinux.cfg
            fi
            cp boot/isolinux/isolinux.cfg ${3}/pxelinux.cfg/default
            cp boot/rootfs.gz ${3}/boot/rootfs.gz
            cp boot/bzImage ${3}/boot/bzImage

            service dnsmasq restart

        else
            service dnsmasq stop
        fi

    fi

}

changeSshPassword(){

    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error $0 changeSshPassword [newPwd]";
        exit 1
    fi

    echo openirudi:${2} | chpasswd
    if [ $? != 0 ]
    then
      echo "ERROR changing password";
      exit 1;
    fi
    echo "!@@@OK!@@@"

}




case $1 in

   'update')
      update ${*}
      ;;
   'getNetDevices')
      getNetDevices ${*}
      ;;
   'deleteImage')
      deleteImage ${*}
      ;;
   'genOpenirudiIso')
      genOpenirudiIso ${*}
      ;;
   'changeSshPassword')
      changeSshPassword ${*}
      ;;
  *)
   echo "Error:"  ${*};
   exit 1
esac;

