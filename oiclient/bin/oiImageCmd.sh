#!/bin/sh

stateFileSize(){
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error stateFileSize [destFiles] ";
        exit 1
    fi

    #SIZE=$(ls -ldk ${2}* | awk '{ SUM += $5} END { print SUM }'  )
    SIZE=$(du -csm ${2}* |grep total |awk '{print $1}' )
    #SIZE=$(expr $SIZE / 1024 / 1024 )
    echo "${SIZE}"
}

stateFsSize(){
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error stateFsSize [destFs] ";
        exit 1
    fi

    SIZE=$(df -m |grep ${2} |awk '{print $3"MB" }' )
    echo "${SIZE}"
}


uploadImage(){
    if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number: error uploadImage [image Id] [oiPartition] [serverMountPoint] ";
        exit 1
    fi

    TSIZE=$(stateFileSize stateFileSize ${2}/${1})
    echo "Upload image (${1}) @@@stateFileSize ${3}/${1}@@@MB/${TSIZE}MB" > /tmp/process
    cp ${2}/${1}* ${3}
    if ( [ $? -ne 0 ] )
    then
        echo "ERROR in sever uploading image"
        echo "${R}"
        exit 1
    fi
}

downloadImage(){
    if [ $# -ne 3  ]; then
        echo "ERROR: Wrong argument number: error downloadImage [files] [oiPartition] [serverMountPoint] ";
        exit 1
    fi
    for FILE in $(echo ${1} |sed 's/,/\ /g' )
    do
        if( ! [ -f ${2}/${FILE} ] )
        then
            echo $(date +"%H:%M:%S") ":  File not exist in local OIpartition ${FILE}"
            TSIZE=$(stateFileSize stateFileSize ${3}/${FILE})
            echo "Download image (${FILE}) @@@stateFileSize ${2}/${FILE}@@@MB/${TSIZE}MB" > /tmp/process

            cp ${3}/${FILE} ${2}/${FILE}
            if ( [ $? -ne 0 ] )
            then
                echo "ERROR in sever downloadig image"
                echo "${R}"
                exit 1
            fi
        else
            echo $(date +"%H:%M:%S") ":  File exist in local OIpartition ${FILE}"
            touch -a ${FILE}
        fi
    done
}

testServer(){
    if [ $# -ne 2  ]; then
        echo "ERROR: Wrong argument number: error $0  testServer [serverMountPoint]";
        exit 1
    fi

    TESTFILE="oiTest_$(/bin/hostname )"
    
    R=$(echo "oiTest File" > "${2}/${TESTFILE}" )
    if ( [ $? -ne 0 ] )
    then
            echo "ERROR in sever uploading/downloadig"
            echo "${R}"
            exit 1
    fi

}


createImage(){
    if [ $# -ne 6  ]; then
        echo "ERROR: Wrong argument number: error $0 createImage [org Partition] [oiPartitionImageFolder] [image Id] [$fs-type] [serverMountPoint]";
        exit 1
    fi
    
    #create image
    testServer testServer ${6}
    if ( [ $? -ne 0 ] )
    then
            echo "ERROR testing Server"
            echo "${R}"
            exit 1
    fi

    if [ -d "${3}" ]
    then
        #clone with oiPartition
        echo "Clone to Openirudi partition"
        DEST_PARTITION=${3}
        UPLOAD=1
    else
        #clone without oiPartition
        echo "Clone without Openirudi partition"
        DEST_PARTITION=${6}
        UPLOAD=0
    fi

    echo "Create image (${4})..." > /tmp/process

    R=1
    case "${5}" in
      'ntfs'|'7'|'ext2'|'ext3'|'ext4'|'fat32'|'83')
        R=$(${BINPWD}/clonePI.sh 'clonePI' ${2} ${DEST_PARTITION} ${4})
        ;;
      'linux-swap'|'swap'|'82')
        #R=$(${BINPWD}/cloneSwap.sh newSwapFs ${2})
        touch ${DEST_PARTITION}/${4}.fsa
        R=0
        ;;
       *)
        echo "I can't create image with this partition format"
    esac;

    if [ $? -ne 0 ];
    then
        echo "ERROR in image creation"
        echo "${R}"
        exit 1
    fi

    if [ -f /tmp/${4}.info ]
    then
        cp /tmp/${4}.info ${DEST_PARTITION}
    else
        echo "NO INFO FILE /tmp/${4}.info"
    fi

    if [ $UPLOAD -eq 1 ]
    then

        RD=$(uploadImage ${4} ${3} ${6})
        if ( [ $? -ne 0 ] )
        then
                echo "ERROR uploading image"
                echo "${RD}"
                exit 1
        fi
    fi

    echo $(date +"%H:%M:%S") ": New image has been created"
    

}

deployImage(){
    if [ $# -ne 7  ]; then
        echo "ERROR: Wrong argument number: error $0 deployImage [oiPartitionImageFolder] [image Id] [files] [dest Partition] [$fs-type] [serverMountPoint]";
        exit 1
    fi

    #deploy image
    testServer testServer ${7}
    if ( [ $? -ne 0 ] )
    then
            echo "ERROR testing Server"
            echo "${R}"
            exit 1
    fi
    R=$(sudo ${BINPWD}/partedCmd.sh 'umountPartition' ${5})
    if ( [ $? -ne 0 ] )
    then
        echo "${R}"
        echo "ERROR umounting partition"
        exit 1
    fi


    if [ -d "${2}" ]
    then
        #clone with oiPartition
        echo "Deploy to Openirudi partition"

        SOURCE_FOLDER=${2}
        RD=$(downloadImage ${4} ${SOURCE_FOLDER} ${7} )
        if ( [ $? -ne 0 ] )
        then
                echo "ERROR downloading image"
                echo "${RD}"
                exit 1
        fi

    else
        #clone without oiPartition
        echo "Deploy without Openirudi partition"
        SOURCE_FOLDER=${7}
    fi

    R=1
    #deploy image"

    echo "Deploy image (${3}) ..." > /tmp/process

    case "${6}" in
      'ntfs'|'7'|'ext2'|'ext3'|'ext4'|'fat32'|'83')
        echo "Download image to oipartition"        
        R=$(${BINPWD}/clonePI.sh 'deployPI' ${SOURCE_FOLDER} ${3} ${5})
        ;;
      'linux-swap'|'swap'|'82')
        R=$(${BINPWD}/cloneSwap.sh newSwapFs ${5})
        ;;
       *)
        echo "I can't deploy image with this partition format"
    esac;
    if ( [ $? -ne 0 ] )
    then
            echo "ERROR in image deploy"
            echo "${R}"
            exit 1
    fi

    P=$(echo ${5} |sed 's/\/dev\///g')
    MAJOR="$(cat /proc/partitions |grep "${P}" |awk '{print $1}' )"
    DISK="$(cat /proc/partitions |awk '$1 == '$MAJOR' {  print $4 }' | head -1 )"

 
    echo " 5: ${5} P $P major $MAJOR disk $DISK " > /tmp/kk.log
    echo " $(fdisk -l ) " >> /tmp/kk.log
    echo " mount: $(mount ) " >> /tmp/kk.log

    echo "${R}"
    echo "-" > /tmp/process
}

removeImage(){
    if [ $# -ne 4  ]; then
        echo "ERROR: Wrong argument number: error $0 removeImage [img list Path] [ImageFilePrefix] [ImageId]";
        exit 1
    fi

    cd ${2}
    for FILE in $(ls "${3}${4}".* )
    do
        echo "file:: ${FILE}";
        if( [ -f ${FILE} ] )
        then
          echo "File exist in local OIpartition ${FILE}"
          rm ${FILE}
        fi
    done
}

cleanProcess(){
    if [ $# -ne 1  ]; then
        echo "ERROR: Wrong argument number: error $0 cleanProcess";
        exit 1
    fi

    chmod 777 /tmp/processAllLog
    rm /tmp/process

}



gparted(){

    A=$(xdotool search "GParted" )
    echo "aaa: $A"
    if [ -z "${A}" ];
    then
        nohup gparted &> /dev/null
        sleep 1
    fi
    xdotool windowactivate $(xdotool search "GParted" | head -1)
    xdotool windowsize $(xdotool search "GParted" | head -1) 800 600

}


BINPWD="/var/www/openirudi/bin";


case $1 in

  'stateFileSize')
      stateFileSize ${*}
      ;;
  'stateFsSize')
      stateFsSize ${*}
      ;;
  'createImage')
      createImage ${*}
      ;;
  'deployImage')
      deployImage ${*}
      ;;
  'removeImage')
      removeImage ${*}
      ;;
  'gparted')
      gparted
      ;;
  'hostName')
      hostName ${*}
      ;;
  'testServer')
      testServer ${*}
      ;;
  'cleanProcess')
      cleanProcess ${*}
      ;;
   *)
     echo "Error: ${*}"
esac;
