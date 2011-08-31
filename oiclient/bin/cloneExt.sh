#!/bin/sh 

resizeExtFs() {
    if [ $# -ne 4  ]; then
        echo "ERROR: Wrong argument number: error $0 resizeExtFs [ext Partition] [newSectors] [type]";
        exit 1
    fi

    

    MINOR=$(echo ${2} |sed 's/[a-zA-Z\/]\{1,\}//')
    DISK=$(echo ${2} |sed 's/[0-9]\{1,\}//')
    SECTORBYTES=$(${BINPWD}/partedCmd.sh sectorBytes ${DISK} |cut -d ';' -f 1 |tr -d 'B' )
    BLOCKSIZE=$(tune2fs -l ${2} |grep -i 'block size'|awk '{print $3}' )
    ${BINPWD}/partedCmd.sh umountPartition ${2}
    partprobe ${DISK}

    START=$(parted ${DISK} unit s print | tr -s ' ' |egrep "^ ${MINOR}" |awk '{print $2}' |tr -d 's' )
    OLD_END=$(parted ${DISK} unit s print | tr -s ' ' |egrep "^ ${MINOR}" |awk '{print $3}' |tr -d 's'  )

    let "BLOCKS=(${3} - ${START}) * ${SECTORBYTES} / ${BLOCKSIZE}"

    TYPE=$(parted ${DISK} print | tr -s ' ' |egrep "^ ${MINOR}" |cut -d ' ' -f 6 )

    if [ ${OLD_END} -gt ${3} ]
    then
        OP='shrink'
    else
        OP='enlarge'
    fi

    echo "Operation:: ${OP}"

    if [ ${OP} == 'enlarge' ];
    then
        ${BINPWD}/partedCmd.sh removePartition ${2}
        ${BINPWD}/partedCmd.sh createPartition ${DISK} ${TYPE} 'ext2' ${START} ${3}
        partprobe ${DISK}
        sleep 1
    fi

    if [ ${OP} == 'enlarge' ] || [ ${OP} == 'shrink' ]
    then
        echo "Run efsck..."
        A=$(/sbin/e2fsck -p -f ${2} )
        if [ $? -ne 0 ];
        then
        echo -e "ERROR running e2fsck step 1"
        echo -e "${A}";
        exit 1
        fi

        echo "Remove file system journal"
        echo "tune2fs -O ^has_journal ${2}"

        B=$(tune2fs -O ^has_journal ${2})
        if [ $? -ne 0 ];
        then
            echo -e "ERROR removeing jounal";
            echo -e "${B}"
            exit 1
        fi

        echo "Rezize filesystem"
        echo "nohup resize2fs ${2} ${BLOCKS} 2>&1"

        C=$(nohup resize2fs ${2} ${BLOCKS} 2>&1 )
        if [ $? -ne 0 ];
        then
            echo "Error resizeing filesystem";
            echo -e "$C"
        fi

        echo "Add journal to new file system"
        echo "tune2fs -j ${2}"

        D=$(tune2fs -j ${2})
        if [ $? -ne 0 ];
        then
            echo "Error adding journal"
            echo -e "${D}"
            #exit 1
        fi

        echo "Run efsck"
        echo "e2fsck -y -v -f ${2}"

        E=$(e2fsck -y -v -f ${2})
        if [ $? -ne 0 ];
        then
        echo -e "ERROR running e2fsck step 2"
        echo $E
        #exit 1
        fi
    fi


    if [ ${OP} == 'shrink' ];
    then
        ${BINPWD}/partedCmd.sh removePartition ${2}
        ${BINPWD}/partedCmd.sh createPartition ${DISK} ${TYPE} 'ext2' ${START} ${3}

        partprobe ${DISK}
        sleep 1
    fi


}

#create EXT filesystem into partition
newExtFs() {

    if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number:  $0 newExtFs [partition] [type]";

        exit 1
    fi

    case ${3} in
      'ext2')
        R=$(mkfs.ext2 -q ${2} )
        ;;
      'ext3')
        R=$(mkfs.ext3 -q ${2} )
        ;;
      'ext4')
        R=$(mkfs.ext4 -q ${2} )
        ;;
    esac;

    echo -e "$R";
}

#change ExtFS label
changeLabel() {

    if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number:  $0 changeLabel [partition] [label]";

        exit 1
    fi

    e2label ${2} ${3}
}


BINPWD="/var/www/openirudi/bin";

case $1 in

  'resizeExtFs')
      resizeExtFs ${*}
      ;;
  'newExtFs')
      newExtFs ${*}
      ;;
  'changeLabel')
      changeLabel ${*}
      ;;
   *)
    echo -e "Error: ${*}"
esac;


