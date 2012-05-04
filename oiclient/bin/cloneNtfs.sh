#!/bin/sh

resizeNtfsFs() {
    if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number: error $0 resizeNtfsFs [ntfs Partition] [new size]";
        exit 1
    fi

    MINOR=$(echo ${2} |sed 's/[a-zA-Z\/]\{1,\}//')
    DISK=$(echo ${2} |sed 's/[0-9]\{1,\}//')
    SECTORBYTES=$(${BINPWD}/partedCmd.sh sectorBytes ${DISK} |cut -d ';' -f 1 |tr -d 'B' )
    BLOCKSIZE=$(ntfsinfo -f -m ${2} 2>/dev/null |grep -i 'Cluster Size'|awk '{print $3}' )

    ${BINPWD}/partedCmd.sh umountPartition ${2}
    partprobe ${DISK}

    START=$(parted ${DISK} unit s print | tr -s ' ' |egrep "^ ${MINOR}" |awk '{print $2}' |tr -d 's' )
    OLD_END=$(parted ${DISK} unit s print | tr -s ' ' |egrep "^ ${MINOR}" |awk '{print $3}' |tr -d 's'  )

    let "SIZEK=( ${3} - ${START}) / 1000  * ${SECTORBYTES}"

    TYPE=$(parted ${DISK} print | tr -s ' ' |egrep "^ ${MINOR}" |cut -d ' ' -f 6 )

    if [ ${OLD_END} -gt ${3} ]
    then
        OP='shrink'
    else
        OP='enlarge'
    fi

    if [ ${OP} == 'enlarge' ];
    then
        ${BINPWD}/partedCmd.sh removePartition ${2}
        ${BINPWD}/partedCmd.sh createPartition ${DISK} ${TYPE} 'ntfs' ${START} ${3}
        partprobe ${DISK}
        sleep 1
    fi

    if [ ${OP} == 'enlarge' ] || [ ${OP} == 'shrink' ]
    then
        R=$(echo "y" | ntfsresize -f --size ${SIZEK}k ${2} )
        if [ $? -ne 0 ];
        then
            echo -e "ERROR resizeing NTFS file system.";
            echo -e "${R}"
            exit 1
        fi
    fi


    if [ ${OP} == 'shrink' ];
    then
        ${BINPWD}/partedCmd.sh removePartition ${2}
        ${BINPWD}/partedCmd.sh createPartition ${DISK} ${TYPE} 'ntfs' ${START} ${3}

        partprobe ${DISK}
        sleep 1
    fi

}


#create NTFS filesystem into partition
newNtfsFs() {
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number:  $0 newNtfsFs [partition]";
        echo "Error: ${*}"
        exit 1
    fi

    R=$(mkfs.ntfs -q -Q $2 )
    echo -e "$R";

}


#change Ntfs FS label
changeLabel() {

    if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number:  $0 changeLabel [partition] [label]";

        exit 1
    fi

    ntfslabel ${2} ${3}
}



BINPWD="/var/www/openirudi/bin";

case $1 in

  'resizeNtfsFs')
      resizeNtfsFs ${*}
      ;;
  'newNtfsFs')
      newNtfsFs ${*}
      ;;
  'changeLabel')
      changeLabel ${*}
      ;;
   *)
    echo -e "Error: ${*}"
esac;


