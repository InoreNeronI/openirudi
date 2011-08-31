#!/bin/sh
error() {
    echo "error ${*}";
}

log() {

	echo -e "\n${*}"
	echo -e "\n${*}" >> LOGFILE

}

mountPartition() {
    if [ $# -ne 2  ] && [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number: $0 mountPartition partition mountPoint";
        exit 1
    fi

    OMP="${#}"
    if [ -z "$(echo ${2} |grep '/dev/' )" ]
    then
        P="/dev/${2}"
    else
        P="${2}"
    fi

    MOUNTPOINT="$(/bin/mount | grep "${2}" |awk '{print $3 }' )"
    if [ -n "${MOUNTPOINT}" ]
    then
        echo "!@@@${MOUNTPOINT}!@@@";
        return;
    fi

    if [ $OMP -eq 2 ]
    then
        echo "!@@@!@@@";
        return;
    fi

    if [ ! -d ${3} ]
    then
        echo "No mountPoint"
        mkdir -p ${3}
    fi

    M=$(/bin/mount ${P} ${3} )
    RES=$?

    if [ $RES -ne 0 ];
    then
        sleep 3
        M=$(/bin/mount ${P} ${3} )
        RES=$?
        echo "RES: $RES M $M"
        if [ $RES -ne 0 ];
        then
            echo -e "ERROR mounting filesystem ERR: ${RES} -- mount ${P} ${3}";
            echo "disks: $(fdisk -l )" > /tmp/mpError.log
            echo "ERROR $(blkid )" >> /tmp/mpError.log
            exit 1
        else
            echo "!@@@${3}!@@@";
        fi
    else
        echo "!@@@${3}!@@@";
    fi

}

umountPartition() {
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: $0 umountPartition partition";
        exit 1
    fi


    RMOUNTPOINT="$(/bin/mount | grep "${2}" |awk '{print $3 }' )"
    if [ -z "${RMOUNTPOINT}" ]
    then
        return;
    fi

    C_MOUNTPOINT=$(mount | grep "${RMOUNTPOINT}" |awk '{print $3 }' |sort -r )
    for M in "${C_MOUNTPOINT}"
    do
        R=$( /bin/umount ${M} )
        if ( [ $? -ne 0 ] )
        then
            echo "I can't umount ${M} result ${R} :: $?"
            exit 1
        fi
    done

}


umountDiskPartitions() {
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: $0 umountDiskPartitions disk";
        exit 1
    fi
    
    LIST=$(${BINPWD}/partedCmd.sh listPartitions ${2} )

    for P in $LIST
    do
        N=$(echo ${P} | cut -d ';' -f 1)
        ${BINPWD}/partedCmd.sh umountPartition ${2}${N}
    done
    

    mount | grep ${2}
    [ $? -ne 0 ] && : || umount ${2}

}

createFileSystem() {
    if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number: $0 createFileSystem partition fs-type";
        exit 1
    fi

    echo "Create File system ..." > /tmp/process

    case "${3}" in
      'ntfs')
        R=$(${BINPWD}/cloneNtfs.sh newNtfsFs ${2})
        ;;
      'linux-swap'|'swap')
        R=$(${BINPWD}/cloneSwap.sh newSwapFs ${2})
        ;;
      'ext2')
        R=$(${BINPWD}/cloneExt.sh newExtFs ${2} 'ext2')
        ;;
      'ext3')
        R=$(${BINPWD}/cloneExt.sh newExtFs ${2} 'ext3')
        ;;
      'ext4')
        R=$(${BINPWD}/cloneExt.sh newExtFs ${2} 'ext4')
        ;;
      'fat32')
        R=$(${BINPWD}/cloneFat.sh newFatFs ${2} )
        ;;
       *)
        echo "I can't format this partition"
    esac;

    if [ $? -ne 0 ];
    then
        echo -e "${R}";
        echo -e "parted ERROR creating new file system"
        exit 1
    else
        partprobe
        echo "New ${3} filesystem has been created in ${2}";
    fi

}

#create partition into device
createPartition() {

    if [ $# -ne 5  ] && [ $# -ne 6  ] && [ $# -ne 7 ];
    then
        echo "ERROR: Wrong argument number: $0 createPartition disk part-type fs-type start_sector end_sector createFS";
        exit 1
    fi

    echo "Create new partition ..." > /tmp/process

    swapoff -a

    if [ ${3} = 'extended' ];
    then
        PTYPE='';
        CREATEFS="0";
        START=${4}
        END=${5}
    else
        START=${5}
        END=${6}

        if [ $# -eq 7  ];
        then
            CREATEFS="1";
        else
            CREATEFS="0";
        fi

        case ${4} in
          'ntfs'|'7')
            PTYPE='ntfs'
          ;;
          'linux-swap'|'swap'|'82')
            PTYPE='linux-swap'
          ;;
          'ext2'|'ext3'|'ext4'|'83')
            PTYPE='ext2'
            ;;
          'fat32'|'c')
            PTYPE='fat32'
            ;;
          *)
            echo "No valid partition Id"
            exit 1
        esac;
        
    fi
   

    OLDTABLE=$(listPartitions listPartitions ${2} )

    R=$(parted -s ${2} mkpart ${3} $PTYPE ${START}s ${END}s)
    if [ $? -ne 0 ];
    then
        echo -e "parted ERROR creating new partition"
        echo -e "${R}";
        exit 1
    fi

    echo -e "$R";
    sleep 2
    partprobe ${2}

    
    NEWTABLE=$(listPartitions listPartitions ${2} )
    
    for ROW in $OLDTABLE
    do
      echo $ROW
      NEWTABLE=$(echo "$NEWTABLE" | sed "s/$ROW//g" | tr -d "\n"  )
    done
   
    if [ -n "${NEWTABLE}" ]
    then
       NEWPARTITION=${2}$(echo "${NEWTABLE}" |cut -d ';' -f1)
    fi

    if [ -n "${NEWPARTITION}" ] ;
    then
        if [ ${CREATEFS} -eq 1 ] && [ ${PTYPE} ];
        then
            partprobe ${2}

            createFileSystem createFileSystem $NEWPARTITION ${4}
            if [ $? -ne 0 ];
            then
                echo "ERROR creating file sytem."
                exit 1
            fi
        fi
    else
        echo "ERROR Partition has not been created";
        exit;
    fi

    #NEWTABLE1=$(listPartitions listPartitions ${2} )
    P=$(echo "${NEWPARTITION}" | sed 's/\/dev\///g' )
    MINOR=$( cat /proc/partitions |grep "${P}" |awk '{print $2}' )
    echo "!@@@${MINOR}!@@@";

}

partedResizePartition(){
    if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number: ${0} resizePartition partition newEnd";
        exit 1
    fi
    swapoff -a

    MINOR=$(echo ${2} |sed 's/[a-zA-Z\/]\{1,\}//')
    DISK=$(echo ${2} |sed 's/[0-9]\{1,\}//')

    partprobe ${DISK}

    HEADSXSECTORS=$(${BINPWD}/partedCmd.sh diskGeometry ${DISK}|awk '{FS=";"; print $2*$3 }')

    START=$(parted ${DISK} unit s print | tr -s ' ' |egrep "^ ${MINOR}" |awk '{print $2}' |tr -d 's' )
    let "NEW_END=( ${3} / ${HEADSXSECTORS} ) * ${HEADSXSECTORS}"

    R=$(parted ${DISK} resize ${MINOR} ${START}s ${NEW_END}s )
    if [ $? -ne 0 ];
    then
        echo -e "${R}";
        echo -e "parted ERROR creating new partition"

        exit 1
    fi

    echo -e "$R";


}

resizePartition(){
    if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number: ${0} resizePartition partition newEnd";
        exit 1
    fi
    swapoff -a

    MINOR=$(echo ${2} |sed 's/[a-zA-Z\/]\{1,\}//')
    DISK=$(echo ${2} |sed 's/[0-9]\{1,\}//')

    umountPartition umountPartition ${2}

    partprobe ${DISK}

    START=$(parted ${DISK} unit s print | tr -s ' ' |egrep "^ ${MINOR}" |awk '{print $2}' |tr -d 's' )
    OLD_END=$(parted ${DISK} unit s print | tr -s ' ' |egrep "^ ${MINOR}" |awk '{print $3}' |tr -d 's'  )

    TYPE=$(parted ${DISK} print | tr -s ' ' |egrep "^ ${MINOR}" |cut -d ' ' -f 6 )

    PARTID=$(fdisk -l ${DISK} |egrep "${2}" | awk '{print $5}')
    FSTYPE_BLKID=$(blkid ${2} |egrep -oi TYPE=\"[a-zA-Z0-9]+\" |cut -d "\"" -f 2 );

    if [ ${OLD_END} -gt ${3} ]
    then
        OP='shrink'
    else
        OP='enlarge'
    fi

    case "${FSTYPE_BLKID}" in
      'ntfs')
        R=$(${BINPWD}/cloneNtfs.sh resizeNtfsFs ${2} ${3} )
        ;;
      'linux-swap'|'swap')
        R=$(${BINPWD}/cloneSwap.sh resizeSwapFs ${2} ${3} )
        ;;
      'ext2'|'ext3'|'ext4')
        R=$(${BINPWD}/cloneExt.sh resizeExtFs ${2} ${3} ${FSTYPE_BLKID} )
        ;;
      'vfat')
        R=$(${BINPWD}/cloneFat.sh resizeFatFs ${2} ${3} )
        ;;
      '')
        #no FS detect
        removePartition removePartition ${2}
        R=$(createPartition createPartition ${DISK} ${TYPE} ${PARTID} ${START} ${3} )
        #echo ${R}
        ;;
      *)
        echo "Resize partition with parted"
        R=$(partedResizePartition partedResizePartition ${2} ${3} )
       
        ;;
    esac;


    if [ $? -ne 0 ];
    then
        echo -e "${R}"
        echo -e "ERROR resizeing file system.";
        exit 1
    else
        echo -e "${R}"
    fi

    partprobe ${DISK}

}



#changePartition type
changePartitionType() {
    if [ $# -ne 4  ]; then
        echo "ERROR: Wrong argument number: ${0} changePartitionType disk number type-fs";
        exit 1
    fi
    umountPartition umountPartition ${2}${3}

    START=$(parted ${2} unit s print | tr -s ' ' |egrep "^ ${3}" |cut -d ' ' -f 3 )
    END=$(parted ${2} unit s print | tr -s ' ' |egrep "^ ${3}" |cut -d ' ' -f 4 )
    TYPE=$(parted ${2} unit s print | tr -s ' ' |egrep "^ ${3}" |cut -d ' ' -f 6 )

    OLDFSTYPE=$(parted ${2} unit s print | tr -s ' ' |egrep "^ ${3}" |cut -d ' ' -f 7 )
    if [ $OLDFSTYPE == 'linux-swap' ]; then
        echo "swapoff partition"
        swapoff -a
    fi

    A=$(mount |grep {2})
    case ${4} in
      '7')
        FSTYPE='ntfs'
      ;;
      '82')
        FSTYPE='linux-swap'
      ;;
      '83')
        FSTYPE='ext2'
      ;;
      'f')
        FSTYPE=''
      ;;
        *)
	echo -e "Error: ${*}"
    esac;


    
    #remove old partition
    removePartition removePartition ${2}${3}
    
    echo "createPartition createPartition  ${2} , ${TYPE} , ${FSTYPE} ,  ${START} , ${END} "
    #create new partition with new size
    partprobe  ${2}
    createPartition createPartition ${2} ${TYPE} ${FSTYPE} ${START} ${END} 
}



#remove partition into device
removePartition() {
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: $0 removePartition Partition";
        exit 1
    fi
    swapoff -a

    DISK=$(echo ${2} |sed 's/[0-9]\{1,\}//')
    MINOR=$(echo ${2} |sed 's/[a-zA-Z\/]\{1,\}//')

    umountPartition umountPartition ${2}

    R=$(parted -s ${DISK} rm ${MINOR} )
    if [ $? -ne 0 ];
    then
        echo "Error removing partition ${2}"
        exit 1
    fi
    echo -e "$R";
}

#list partition into device
listPartitions() {
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number:  $0 listPartitions disk";
        exit 1
    fi
 
    R=$(parted -s $2 unit s print|tr -s ' ' |egrep '^ [0-9]+ [0-9]+s [0-9]+s'|sed 's/^ //g'|tr -s ' ' ';' )
    echo -e "$R";
}

#list devices
listDevices() {
    if [ $# -ne 1  ]; then
        echo "ERROR: Wrong argument number: error $0 listDevices ";
        exit 1
    fi
    
    R=$(cat /proc/partitions |tr -s ' ' |egrep '^ [0-9]+ '|cut -d ' ' -f 5|egrep -v '[0-9]')
    echo -e "!@@@${R}!@@@"

}

#new partition table
newPartitionTable() {
    echo "newPartitionTable";
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error $0 newPartitionTable device";
        exit 1
    fi
    R=$(parted -s $2 mklabel msdos)
    echo -e "$R"
}


#show partition table
partitionTable() {
    Z=$#
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error $0 partitionTable device";
        echo "z: $Z"
        exit 1
    fi

    R=$(sudo /sbin/fdisk /dev/${2} -u -l | egrep "^/dev/[a-z]+[0-9]+\ " | tr -s " " )
    echo -e "!@@@${R}!@@@"
}


#disk geometry
diskGeometry() {

    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error $0 diskGeometry [disk]";
        exit 1
    fi

    if [ -z "$(echo ${2} |grep '/dev/' )" ]
    then
        D="/dev/${2}"
    else
        D="${2}"
    fi
    R=$(parted -s ${D} unit cyl print | egrep 'geometry: [0-9]+,[0-9]+,[0-9]+\.\ '|cut -d ':' -f 2 |cut -d '.' -f 1|tr -d ' ' | tr -s ',' ';' )
    echo -e "!@@@${R}!@@@"

}

#disk sector size
sectorBytes() {
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error $0 sectorBytes disk";
        exit 1
    fi
    R=$(parted -s $2 print|grep 'Sector size (logical/physical):'|cut -d ':' -f 2| tr -s '/' ';' )
    echo -e "$R"
}

#diskSize
diskSize() {
   if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error $0 diskSize";
        exit 1
    fi
    
    G=$($0 'diskGeometry' ${2} )
    G2=$(expr match "${G}" '.*!@@@\([[:digit:];]*\)!@@@*.'  )

    SIZE=$(expr $(echo "${G2}" |cut -d ';' -f 1 ) \* $(echo "${G2}"|cut -d ';' -f 2 ) \* $(echo "${G2}"|cut -d ';' -f 3 ) - 1 )
    echo -e "${SIZE}s"

}

partitionLabel() {
   if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number: error $0 partitionLabel [partition] [lablel]";
        exit 1
    fi

    #set label
    R=$(e2label ${2} "${3}")
    if [ $? != 0 ]
    then
      echo "error setting label in partition";
      exit;
    fi
}

partitionFlag() {
   if [ $# -ne 4  ]; then
        echo "ERROR: Wrong argument number: error $0 partitionFlag [partition] [flag] [value]";
        exit 1
    fi
    MINOR=$(echo ${2} |sed 's/[a-zA-Z\/]\{1,\}//')
    DISK=$(echo ${2} |sed 's/[0-9]\{1,\}//')


    R=$(parted ${DISK} set ${MINOR} ${3} ${4} )
    if [ $? != 0 ]
    then
      echo "error setting flag in partition";
      exit;
    fi
}

diskInfo() {
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error $0 diskSerial [disk]";
        exit 1
    fi
    if [ -z "$(echo ${2} |grep '/dev/' )" ]
    then
        D="/dev/${2}"
    else
        D="${2}"
    fi

    INFO=$(hdparm -i ${D} 2>/dev/null |sed "s/^\ //g" | sed "s/,\ /\n/g" )

    #SERIAL=$(udevadm info -a -p /sys/block/${D} |grep serial |awk '{FS="=="; print $2}'|tr -d '"' )
    SERIAL=$(echo "$INFO" |grep "SerialNo=" | awk '{ FS="="; print $2 }' )
    if [ $? != 0 ]
    then
      echo "Error udevadm";
      exit 1;
    fi
    #SIZE=$(udevadm info -a -p /sys/block/${D} |grep size |awk '{FS="=="; print $2}'|tr -d '"' )
    SIZE=$(echo "$INFO" |grep "LBAsects=" | awk '{ FS="="; print $2 }' )
    if [ $? != 0 ]
    then
      echo "Error udevadm";
      exit 1;
    fi
    #MODEL=$(udevadm info -a -p /sys/block/${D} |grep model |awk '{FS="=="; print $2}'|tr -d '"' )
    MODEL=$(echo "$INFO" |grep "Model=" | awk '{ FS="="; print $2 }' )
    if [ $? != 0 ]
    then
      echo "Error udevadm";
      exit 1;
    fi
    #FW=$(udevadm info -a -p /sys/block/${D} |grep firmware |awk '{FS="=="; print $2}'|tr -d '"' )
    FW=$(echo "$INFO" |grep "FwRev=" | awk '{ FS="="; print $2 }' )
    if [ $? != 0 ]
    then
      echo "Error udevadm";
      exit 1;
    fi

    echo -e "!@@@${MODEL};${FW};${SERIAL};${SIZE}!@@@"

}

diskSignature() {
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error $0 diskSignature [disk]";
        exit 1
    fi
    E=$( od -N 4 -t x4 -j 440 /dev/${2} 2>/dev/null  |awk '{print $2}'  )
    if [ -z "${E}" ]; then
        echo "@@ERROR@@"
    else
        echo "@@${E}@@"
    fi

}

resync() {
    if [ $# -ne 1  ]; then
        echo "ERROR: Wrong argument number: error $0 resync";
        exit 1
    fi

    R=$(listDevices listDevices)
    R2=$(expr match "${R}" '.*!@@@\([[:alnum:]]*\)!@@@*.'  )
    for DEVICE in "${R2}"
    do
        partprobe /dev/${DEVICE}
   done
}

swapOff() {
    if [ $# -ne 1  ]; then
        echo "ERROR: Wrong argument number: error $0 swapoff";
        exit 1
    fi

    R=$(free |awk '{ if ($1=="Swap:" && $2>0) print $0 }' )
    if [ $? != 0 ]
    then
      echo "error in free query";
      exit;
    fi
    if [ -n "${R}" ]
    then
        echo "Swapoff egin"
        /sbin/swapoff -a
    else
        echo "Swapoff egina dago"
    fi

}



BINPWD="/var/www/openirudi/bin";

case $1 in

  'createPartition')
      createPartition ${*}
      ;;
  'resizePartition')
      resizePartition ${*}
      ;;
  'changePartitionType')
      changePartitionType ${*}
      ;;
  'removePartition')
      removePartition ${*}
      ;;
  'listPartitions')
      listPartitions ${*}
      ;;
  'listDevices')
      listDevices ${*}
      ;;
  'newPartitionTable')
      newPartitionTable ${*}
      ;;
  'newExt4Fs')
      newExt4Fs ${*}
      ;;
   'newExt3Fs')
      newExt3Fs ${*}
      ;;
   'newNtfsFs')
      newNtfsFs ${*}
      ;;
  'partitionTable')
      partitionTable ${*}
      ;;
  'diskGeometry')
      diskGeometry ${*}
      ;;
  'sectorBytes')
      sectorBytes ${*}
      ;;
  'diskSize')
      diskSize ${*}
      ;;
  'resync')
      resync ${*}
      ;;
  'mountPartition')
      mountPartition ${*}
      ;;
  'umountPartition')
      umountPartition ${*}
      ;;
  'umountDiskPartitions')
      umountDiskPartitions ${*}
      ;;
  'partitionFlag')
      partitionFlag ${*}
      ;;
  'partitionLabel')
      partitionLabel ${*}
      ;;
  'diskInfo')
      diskInfo ${*}
      ;;
  'diskSignature')
      diskSignature ${*}
      ;;
  'swapOff')
      swapOff ${*}
      ;;
  *)
    echo -e "Error: ${*}"
esac;
