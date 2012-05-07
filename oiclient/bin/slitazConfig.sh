#!/bin/sh

changeConfProperty() {
    PROPERTY=${1}
    VALUE=${2}
    FILE=$(echo "${3}" | sed "s/^-\//\//g" )

    propvalue=$( sed '/^\#/d' ${FILE} | grep ${PROPERTY} | tail -n 1 | sed 's/^.*=//;s/^[[:space:]]*//;s/[[:space:]]*$//')
    A="`echo | tr '\012' '\001' `"
    sed -i -e "s${A}${PROPERTY}=${propvalue}${A}${PROPERTY}=${VALUE}${A}" ${FILE}

}


#change openirudi system ip
changeIp() {
    if [ $# -lt 4  ]; then
        echo "ERROR: Wrong argument number:  $0 changeIp [oisystemPath] [static/dhcp] [device] [ip] [netmask] [gateway] [dns_server]";
        exit 1
    fi

    echo "$0 changeIp [oisystemPath]=${2} [static/dhcp]=${3} [device]=${4} [ip]=${5} [netmask]=${6} [gateway]=${7} [dns_server]=${8}"


    NETWORK_CONF_FILE=${2}"/etc/network.conf"

    if [ -n "$(pidof udhcpc)" ]
    then
        /bin/kill $(pidof udhcpc)
    fi

    if [ "${3}" = "static" ];
    then
        /sbin/ifconfig ${4} ${5} netmask ${6} up
        OLD_ROUTE=$(route -n|egrep "^0.0.0.0"|awk '{print $1}');
        if [ -n "${OLD_ROUTE}" ]
        then
            /sbin/route del default gw $OLD_ROUTE
        fi
        /sbin/route add default gw ${7}
        echo "nameserver ${8}" > /etc/resolv.conf

        changeConfProperty 'DHCP' '"no"' ${NETWORK_CONF_FILE}
        changeConfProperty 'STATIC' '"yes"' ${NETWORK_CONF_FILE}
        changeConfProperty 'IP' "\"${5}\"" "${NETWORK_CONF_FILE}"
        changeConfProperty 'NETMASK' "\"${6}\"" "${NETWORK_CONF_FILE}"
        changeConfProperty 'GATEWAY' "\"${7}\"" "${NETWORK_CONF_FILE}"
        changeConfProperty 'DNS_SERVER' "\"${8}\"" "${NETWORK_CONF_FILE}"
    else
        /sbin/udhcpc -b -T 3 -A 12 -i ${4} -p /var/run/udhcpc.${4}.pid
        changeConfProperty 'DHCP' '"yes"' ${NETWORK_CONF_FILE}
        changeConfProperty 'STATIC' '"no"' ${NETWORK_CONF_FILE}
        sleep 1
    fi

}

isDhcp() {
    if [ $# -ne 1  ]; then
        echo "ERROR: Wrong argument number: error $0 isDhcp";
        exit 1
    fi

    DEV=$( /bin/ps -fe |grep -v grep|grep udhcpc|tr -s " " |cut -d " " -f 12 )
    echo $DEV

}

getHostName(){
    if [ $# -ne 1  ]; then
        echo "ERROR: Wrong argument number: error $0 getHostName";
        exit 1
    fi
    echo $(hostname)
}

setHostName(){

    if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number: error $0 setHostName [oisystemPath] [newName]";
        exit 1
    fi

    HOSTNAME_FILE="${2}/etc/hostname"
    HOSTS_FILE="${2}/etc/hosts"

    hostname ${3}
    echo ${3} > ${HOSTNAME_FILE}
    echo "127.0.0.1 localhost ${3}" > ${HOSTS_FILE}
    echo $(hostname)

}
getNetDevices(){
    if [ $# -ne 1  ]; then
        echo "ERROR: Wrong argument number: error $0 getNetDevices";
        exit 1
    fi
    DEV=$( ip link | egrep -w '(UP|UNKNOWN)' |grep -v lo: |awk '{print $2}' |tr -d ':' |head -1 )
    if [ $? != 0 ]
    then
      echo "ERROR listing network devices";
      exit;
    fi

    if [ -z "${DEV}" ]
    then
        DEV=$(cat /proc/net/dev |grep ':' | grep -v lo: |cut -d ":" -f 1| tr -d " " |head -1 )
    fi

    echo "!@@@$DEV!@@@"

}

getSystemPartition(){
    if [ $# -ne 1  ]; then
        echo "ERROR: Wrong argument number: error $0 getSystemPartition";
        exit 1
    fi

    SYS=$(expr match "$(cat /proc/cmdline)" '.*root=\([a-zA-Z0-9//]*\)*.'|sed 's/\/dev\///g')
    if [ $? != 0 ]
    then
      echo "ERROR geting system partition";
      exit;
    fi
    echo "!@@@${SYS}!@@@"

}

setConfProperty(){
    if [ $# -ne 4  ]; then
        echo "ERROR: Wrong argument number: error $0 setConfProperty [file] [property] [value]";
        exit 1
    fi
    if [ -f ${2} ]
    then
        REST=$(grep -v "${3}:" ${2} )
        echo "${REST}" > ${2}
        echo "${3}: ${4}" >> ${2}

        echo "${3} changed"
    fi
}

setOiServer(){
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error $0 setOiServer [server]";
        exit 1
    fi
    REST=$(grep -v "imageServer:" /var/www/openirudi/cache/openirudi.yml )
    echo "${REST}" > /var/www/openirudi/cache/openirudi.yml
    echo "imageServer: ${2}" >> /var/www/openirudi/cache/openirudi.yml

    echo "Sever changed"
}

setInitParams(){
    if [ $# -ne 1  ]; then
        echo "ERROR: Wrong argument number: error $0 setInitParams";
        exit 1
    fi

    cat /proc/cmdline > /tmp/init.log

    ifconfig >> /tmp/init.log


    IP=""
    for P in $(cat /proc/cmdline )
    do
        PARAM=$(echo "${P}" | cut -d '=' -f 1 )
        VALUE=$(echo "${P}" | cut -d '=' -f 2 )

        case ${PARAM} in
            'server')
                setOiServer setOiServer ${VALUE}
            ;;
            'type')
                TYPE="${VALUE}"
            ;;
            'ip')
                IP="${VALUE}"
            ;;
            'netmask')
                NETMASK="${VALUE}"
            ;;
            'gateway')
                GATEWAY="${VALUE}"
            ;;
            'dns1')
                DNS1="${VALUE}"
            ;;
            'useroi')
                USER="${VALUE}"
            ;;
            'password')
                PASSWORD="${VALUE}"
            ;;

        esac
    done;

    R=$(getNetDevices getNetDevices)
    N=$(echo "${R}"|grep '!@@@' | cut -d ';' -f1|sed 's/!@@@//g' |tr -s "\n" |tr -d " " |head -1 )
    if [ -z "${N}" ];
    then
        echo "Error network devices";
    else
        if [ -n "${IP}" ] && [ -n "${GATEWAY}" ] && [ -n "${DNS1}" ]
        then
            echo "static ${N} ${IP} ${NETMASK} ${GATEWAY} ${DNS1}" >> /tmp/init.log
            changeIp changeIp "" "static" ${N} ${IP} ${NETMASK} ${GATEWAY} ${DNS1}
        elif [ -z "$(ifconfig ${N} |grep addr: )" ]
        then
            echo "No ip found "
            changeIp changeIp "" "dhcp" ${N} 
        fi
    fi
    echo "init ip address was set..." >> /tmp/init.log


    if [ -n "${USER}" ] && [ -n "${PASSWORD}" ]
    then
        echo "user changed"
        if [ -f /var/www/openirudi/lib/common/user_list.txt ]
        then
            rm /var/www/openirudi/lib/common/user_list.txt
        fi
        echo "${USER}:${PASSWORD}" > /var/www/openirudi/lib/common/user_list.txt
        cat /var/www/openirudi/lib/common/user_list.txt >> /tmp/init.log
    fi

    cp -a /etc/midori_config /etc/midori_config_w

    echo "init params was set..." >> /tmp/init.log

}

changePassword(){
    if [ $# -ne 4 ]; then
        echo "ERROR: Wrong argument number: error $0 changePassword [user] [newPwd] [newPwdmd5]";
        exit 1
    fi

    A=$(expect $BINPWD/slitazPwd.tcl root ${3} )
    if [ $? != 0 ]
    then
      echo "ERROR changeing password";
      echo -e "$A"
      exit 1;
    fi
    
    echo "user changed"
    if [ -f /var/www/openirudi/lib/common/user_list.txt ]
    then
        rm /var/www/openirudi/lib/common/user_list.txt
    fi
    echo "${2}:${4}" > /var/www/openirudi/lib/common/user_list.txt

    echo "!@@@OK!@@@"

}

setGrubEnv(){
    if [ $# -ne 4 ]; then
        echo "ERROR: Wrong argument number: error $0 setGrubEnv [oisystemPath] [envVar] [value]";
        exit 1
    fi
    /usr/bin/grub-editenv ${2}/boot/grub/grubenv set ${3}=${4}

}

bootPartition(){
    if [ $# -ne 3 ]; then
        echo "ERROR: Wrong argument number: error $0 bootPartition [oisystemPath] [index]";
        exit 1
    fi
    /usr/bin/grub-editenv ${2}/boot/grub/grubenv set GRUB_DEFAULT=${3}

    reboot

}

grubInstall(){

    if [ $# -ne 3 ]; then
        echo "ERROR: Wrong argument number: error $0 grubInstall [oisystemDisk] [mountPoint]";
        exit 1
    fi

    echo "Grub install" > /tmp/process

    #install NEW grub
    echo "Install new mbr"
    CMD="chroot ${3} /usr/sbin/grub-install --no-floppy  --recheck /dev/${2}"
    echo "GRUB install command:: ${CMD}"

    C=$($CMD)
    if [ $? != 0 ]
    then
        echo "RESULT::: $C"
        echo "Error occurred"
    else
        echo "RESULT::: $C"
    fi

    echo "-" > /tmp/process

}

grubReadMenu(){
    if [ $# -ne 2 ]; then
        echo "ERROR: Wrong argument number: error $0 grubReadMenu [menuFile] ";
        exit 1
    fi
    cat $2
}

grubSaveMenu(){
    if [ $# -ne 3 ]; then
        echo "ERROR: Wrong argument number: error $0 grubSaveMenu [menuFile] [newMenu] ";
        exit 1
    fi

    cp $2 /tmp/$(date +%s).grub
    cat "${3}" > ${2}

}

backCommand(){

    nohup ${2} ${3} ${4} ${5} > /tmp/kk2.log 2>&1 &

}


#   isDhcp:         'sudo /bin/ps -fe |grep -v grep|grep udhcpc|tr -s " " |cut -d " " -f 11'
#   getethdevices:  'sudo /sbin/ifconfig |grep eth|tr -s " " |cut -d " " -f 1'
#   getipaddress:   'sudo /sbin/ifconfig $device|grep "inet addr"|tr -s " "'
#   getMACaddress:  'sudo /sbin/ifconfig|grep "HWaddr"|tr -s " "'
#   getgateway:     'sudo /sbin/route -n |tr -s " "'



BINPWD="/var/www/openirudi/bin";

case $1 in

  'changeIp')
      changeIp ${*}
      ;;
  'isDhcp')
      isDhcp ${*}
      ;;
  'setConfProperty')
      setConfProperty ${*}
      ;;
  'setHostName')
      setHostName ${*}
      ;;
   'getHostName')
      getHostName ${*}
      ;;
   'getSystemPartition')
      getSystemPartition ${*}
      ;;
   'setInitParams')
      setInitParams ${*}
      ;;
   'changePassword')
      changePassword ${*}
      ;;
   'setGrubEnv')
      setGrubEnv ${*}
      ;;
   'bootPartition')
      bootPartition ${*}
      ;;
   'grubInstall')
      grubInstall ${*}
      ;;
   'grubReadMenu')
      grubReadMenu ${*}
      ;;
   'grubSaveMenu')
      grubSaveMenu ${*}
      ;;
    'backCommand')
      backCommand ${*}
      ;;
  *)
   echo "Error:"  ${*};
esac;
