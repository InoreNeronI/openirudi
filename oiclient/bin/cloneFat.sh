#!/bin/sh

resizeFatFs() {
  if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number: error $0 resizeFatFs [fat Partition] [new size]";
        exit 1
  fi
  MINOR=$(echo ${2} |sed 's/[a-zA-Z\/]\{1,\}//')
  DISK=$(echo ${2} |sed 's/[0-9]\{1,\}//')
  START=$(parted ${DISK} unit s print | tr -s ' ' |egrep "^ ${MINOR}" |awk '{print $2}' |tr -d 's' )

  partprobe ${DISK}

  R=$(parted $DISK resize ${MINOR} ${START} ${3} )
  if [ $? -ne 0 ];
  then
    echo -e "ERROR resizeing NTFS file system.";
    echo -e "${R}";
    exit 1
  fi

}


#create FAT filesystem into partition
newFatFs() {
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number:  $0 newFatFs [partition]";
        echo "Error: ${*}"
        exit 1
    fi
    MINOR=$(echo ${2} |sed 's/[a-zA-Z\/]\{1,\}//')
    DISK=$(echo ${2} |sed 's/[0-9]\{1,\}//')
    R=$(parted -s ${DISK} mkfs ${MINOR} fat32 )

    if [ $? -ne 0 ];
    then
        echo -e "ERROR resizeing NTFS file system.";
        echo -e "${R}";
        exit 1
    fi
    echo -e "${R}";
}

case $1 in

  'resizeFatFs')
      resizeFatFs ${*}
      ;;
  'newFatFs')
      newFatFs ${*}
      ;;
   *)
    echo -e "Error: ${*}"
esac;


