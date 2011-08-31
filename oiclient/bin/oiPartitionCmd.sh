#!/bin/sh

createOiPartition() {
   if [ $# -ne 5  ]; then
        echo "ERROR: Wrong argument number: error $0 createOiPartition [disk] [start] [end] [ptype]";
        exit 1
    fi

    ${BINPWD}/partedCmd.sh umountDiskPartitions ${2}
      
    echo "${BINPWD}/partedCmd.sh createPartition ${2} ${5} 'ext3' ${3} ${4} createFS"

    OLDTABLE=$(${BINPWD}/partedCmd.sh listPartitions ${2} )
    R=$(${BINPWD}/partedCmd.sh createPartition ${2} ${5} 'ext3' ${3} ${4} createFS)
    if [ $? != 0 ]
    then
      echo -e "${R}"
      echo "Error creating partition";
      exit 1;
    fi
    echo "OpenIrudi cache partition created succesfully"
    partprobe ${2}

    NEWTABLE=$(${BINPWD}/partedCmd.sh listPartitions ${2} )

    for ROW in $OLDTABLE
    do
      echo $ROW
      NEWTABLE=$(echo "$NEWTABLE" | sed "s/$ROW//g" | tr -d "\n"  )
    done

    if [ -n "${NEWTABLE}" ]
    then
       NEWPARTITION=${2}$(echo "${NEWTABLE}" |cut -d ';' -f1)
    fi

    if [ -z "${NEWPARTITION}" ] ;
    then
        echo "We not found new partition"
        exit 1
    fi


#echo "partitions:: $(fdisk -l)";
#echo "blkid: $(blkid ${NEWPARTITION})"

echo "e2label ${NEWPARTITION} OICache"
    sleep 2

    #set label
    R=$(e2label ${NEWPARTITION} 'OICache')
    if [ $? != 0 ] 
    then
      echo "error setting OiPartition filesystem label";
      echo "error: ${R}"
      exit 1;
    fi
    echo "OiPartition label was created"
    MOUNTPOINT='/tmp/oi_'$(echo ${NEWPARTITION}| cut -d '/' -f 3)

    if ! [ -d ${MOUNTPOINT} ]
    then
      mkdir ${MOUNTPOINT}
    fi

    mount ${NEWPARTITION} ${MOUNTPOINT}
    if [ $? != 0 ] 
    then
      echo "error mounting new OiPartition";
      exit 1;
    fi
    mkdir ${MOUNTPOINT}/openirudi

echo
echo "ls: $(ls -ld ${MOUNTPOINT}/*)"
echo

    umount ${MOUNTPOINT}
    partprobe ${2}


    R=$(${BINPWD}/SlitazInstall.sh ${NEWPARTITION})
    if ( [ $? -ne 0 ] )
    then
        echo "ERROR in slitaz instalation"
        echo "${R}"
        exit 1
    fi
echo
echo ${R}
echo

    echo "OiPartition system was created sucessfully"

}

deleteOiPartition() {
   if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error $0 deleteOiPartition ";
        exit 1
    fi

    #delete partition


}

resizeOiPartition() {
   if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error $0 resizeOiPartition ";
        exit 1
    fi

    #resize FS.
    
    #resize Partition.

}


listOiPartitions() {
   if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error $0 listOiPartitions ";
        exit 1
    fi

    #resize FS.
    
    #resize Partition.

}

BINPWD="/var/www/openirudi/bin";

case $1 in

  'createOiPartition')
      createOiPartition ${*}
      ;;
  'deleteOiPartition')
      deleteOiPartition ${*}
      ;;
  'resizeOiPartition')
      resizeOiPartition ${*}
      ;;
  'listOiPartitions')
      listOiPartitions ${*}
      ;;
  *)
     echo -e "Error: ${*}"
esac;


