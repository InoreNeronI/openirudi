#!/bin/sh

resizeSwapFs() {
    if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number: error $0 resizeSwapFs [Partition] [new size]";
        exit 1
    fi

    MINOR=$(echo ${2} |sed 's/[a-zA-Z\/]\{1,\}//')
    DISK=$(echo ${2} |sed 's/[0-9]\{1,\}//')

    partprobe ${DISK}

    START=$(parted ${DISK} unit s print | tr -s ' ' |egrep "^ ${MINOR}" |awk '{print $2}' |tr -d 's' )
    #NEW_END=$(expr $START + ${3} )

echo "swapFS parted ${DISK} resize ${MINOR} ${START}s ${3}s "
    echo parted ${DISK} resize ${MINOR} ${START}s ${3}s
    R=$(parted ${DISK} resize ${MINOR} ${START}s ${3}s)
    if [ $? -ne 0 ];
    then
        echo -e "${R}";
        echo -e "parted ERROR resize swap partition"

        exit 1
    fi

}


#create Swap filesystem into partition
newSwapFs() {
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number:  $0 newSwapFs [partition]";
        echo "Error: ${*}"
        exit 1
    fi
    R=$(mkswap  ${2})
    if [ $? -ne 0 ];
    then
        echo -e "${R}";
        echo -e "parted ERROR creating swap partition"

        exit 1
    fi


}



case $1 in

  'resizeSwapFs')
      resizeSwapFs ${*}
      ;;
  'newSwapFs')
      newSwapFs ${*}
      ;;
   *)
    echo -e "Error: ${*}"
esac;


