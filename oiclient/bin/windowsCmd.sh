#!/bin/sh

fixmbr(){
    if [ $# -ne 3 ]; then
        echo "ERROR: Wrong argument number: error $0 fixmbr [type] [partition]";
        exit 1
    fi

    DISK=$(echo ${3} |sed 's/[0-9]\{1,\}//')
    MINOR=$(echo ${3} |sed 's/[a-zA-Z\/]\{1,\}//')

    case $2 in

      'windows7system')
          ms-sys --mbr7 ${DISK}
          ;;
      'windows7')
          ms-sys --mbr7 ${DISK}
          ;;
      'vista')
          ms-sys --mbrvista ${DISK}
          ;;
      'windowsXP')
          ms-sys --mbr ${DISK}
          ;;
       *)
         echo -e "Error: ${*}"
    esac;

.    ${BINPWD}/partedCmd.sh partitionFlag ${3} boot on
}

exportRegistryKey(){
    if [ $# -ne 5 ]; then
        echo "ERROR: Wrong argument number: error $0 exportRegistryKey [hiveFile] [prefix] [key] [exportFile]";
        exit 1
    fi

    if [ -f ${5} ]
    then
        rm ${5}
    fi

    PREFIX="$(echo -e "${3}" )"
    KEY="$(echo -e "${4}" )"

echo "PREFIX== ${PREFIX}"
echo "KEY== ${KEY}"

    CMD="/usr/sbin/reged -x ${2} ${PREFIX} ${KEY} ${5}"

    A="$($CMD )"
echo "CMD:: $CMD"
 echo "RESULT::: $A"

    if [ $? != 0 ] && [ ! -f ${5} ]
    then
        echo "RESULT::: $A"
        echo "Error occurred"
    fi
echo $CMD
    chown www:www ${5}


}

importRegistryKey(){
    if [ $# -ne 4 ]; then
        echo "ERROR: Wrong argument number: error $0 importRegistryKey [hiveFile] [prefix] [importFile]";
        exit 1
    fi

    R=$(reged -C -I "${2}" "${3}" "${4}" 2>&1 )
    if [ $R != 0 ] || [ -z "$( echo $R |grep 'SUCCEEDED!' )" ]
    then
        echo "ERROR import Result"
        echo "${R}"
        exit 1
    fi


}




modifyMultiSZRegistryKey(){
    if [ $# -ne 4 ]; then
        echo "ERROR: Wrong argument number: error $0 modifyMultiSZRegistryKey [hiveFile] [key] [value]";
        exit 1
    fi

 #{ls "cd Objects\\{9dea862c-5cdd-4e70-acc1-f32b344d4795}\\Elements\\11000001" "ed Element" ": 00 44 44 44" "s" "q" "-" }
    if [ -f /tmp/regedit.cmd ]
    then
        rm /tmp/regedit.cmd
    fi

    KEYALL=$(echo -e "${3}" )
    KEYPATH=${KEYALL%\\*}
    KEY=${KEYALL##*\\}

    echo "cd $(echo "${KEYPATH}" |tr -s '\' '\\')" > /tmp/regedit.cmd
    echo "ed $(echo "${KEY}" |tr -s '\' '\\')" >> /tmp/regedit.cmd
    echo "$(echo ${4}|tr -s ',' ' ')" >> /tmp/regedit.cmd
    echo "--n" >> /tmp/regedit.cmd


    R=$(expect ${BINPWD}/regedit.tcl ${2} )
    if [ $? != 0 ]
    then
        echo "Error occurred"
        echo -e "${R}"
        exit 1
    fi
    echo -e "${R}"
}




modifyHexRegistryKey(){
    if [ $# -ne 5 ]; then
        echo "ERROR: Wrong argument number: error $0 modifiHexRegistryKey [hiveFile] [key] [offset] [value]";
        exit 1
    fi

 #{ls "cd Objects\\{9dea862c-5cdd-4e70-acc1-f32b344d4795}\\Elements\\11000001" "ed Element" ": 00 44 44 44" "s" "q" "-" }
    if [ -f /tmp/regedit.cmd ]
    then
        rm /tmp/regedit.cmd
    fi

    KEYALL=$(echo -e "${3}" )
    #KEYALL=$(echo "${3}" )

  
    # '\\!!' Secuencia de escape, separador ruta-clave registro
    if [ -n "$(echo "${KEYALL}" |grep '\\!!' )"  ]
    then
        KEYALL=$(echo "${3}" )
        KEYPATH=${KEYALL%\\!!*}
        KEY=${KEYALL##*\\!!}
    else
        KEYPATH=${KEYALL%\\*}
        KEY=${KEYALL##*\\}
    fi


echo "KEYALL ${KEYALL}"
echo "KEYPATH ${KEYPATH}"
echo "KEY ${KEY}"


    echo "cd $(echo "${KEYPATH}" |tr -s '\' '\\')" > /tmp/regedit.cmd
    echo "ed $(echo "${KEY}" |tr -s '\' '\\')" >> /tmp/regedit.cmd
    echo ": ${4} $(echo ${5}|tr -s ',' ' ')" >> /tmp/regedit.cmd
    echo "s" >> /tmp/regedit.cmd


    R=$(expect ${BINPWD}/regedit.tcl ${2} )
    if [ $? != 0 ]
    then
        echo "Error occurred"
        echo -e "${R}"
        exit 1
    fi
    echo -e "${R}"
}

modifyStrRegistryKey(){
    if [ $# -ne 4 ]; then
        echo "ERROR: Wrong argument number: error $0 modifyStrRegistryKey [hiveFile] [key] [value]";
        exit 1
    fi

    if [ -f /tmp/regedit.cmd ]
    then
        rm /tmp/regedit.cmd
    fi
    KEYALL=$(echo -e "${3}" )
    KEYPATH=${KEYALL%\\*}
    KEY=${KEYALL##*\\}


echo "KEYALL ${KEYALL}"
echo "KEYPATH ${KEYPATH}"
echo "KEY ${KEY}"



    echo "cd $(echo "${KEYPATH}" |tr -s '\' '\\')" > /tmp/regedit.cmd
    echo "ed $(echo "${KEY}" |tr -s '\' '\\')" >> /tmp/regedit.cmd
    echo "${4}" >> /tmp/regedit.cmd
   
    R=$(expect ${BINPWD}/regedit.tcl ${2} )
    if [ $? != 0 ]
    then
        echo "Error occurred"
        echo -e "${R}"
        exit 1
    fi
    echo -e "${R}"
}




BINPWD="/var/www/openirudi/bin";

case $1 in

   'fixmbr')
      fixmbr ${*}
      ;;
   'exportRegistryKey')
      exportRegistryKey ${*}
      ;;
  'modifyHexRegistryKey')
      modifyHexRegistryKey ${*}
      ;;
  'modifyStrRegistryKey')
      modifyStrRegistryKey ${*}
      ;;
  'modifyMultiSZRegistryKey')
      modifyMultiSZRegistryKey ${*}
      ;;
  'importRegistryKey')
      importRegistryKey ${*}
      ;;
  *)
   echo "Error:"  ${*};
esac;

