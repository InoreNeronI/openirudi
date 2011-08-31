#!/bin/sh

clonePI() {
  if [ $# -ne 4  ]; then
        echo "ERROR: Wrong argument number: error $0 clonePI [org Partition] [dest Path] [image Id]";
        exit 1
  fi

  echo "Create image @@@stateFileSize ${3}/${4}@@@MB..." > /tmp/process
  
  R=$(fsarchiver -o -j 2 -z 1 savefs -s 1000 ${3}/${4}.fsa ${2})
  if ( [ $? -ne 0 ] )
  then
            echo "ERROR in fsarchiver image creation"
            echo "${R}"
            exit 1
  fi

  echo $(date +"%H:%M:%S") ":  Finish fsarchive creating image"

}

deployPI() {
  if [ $# -ne 4  ]; then
        echo "ERROR: Wrong argument number: error $0 deployPI [img list Path] [image Id] [dest Partition]";
        exit 1
  fi

  TSIZE=$(fsarchiver archinfo ${2}/${3}.fsa 2>&1 |grep -i "Space used" | cut -d ':' -f 2 |awk '{print $1$2}' )
  echo "Deploy image (${3})  @@@stateFsSize ${4}@@@/${TSIZE}..." > /tmp/process


  echo $(date +"%H:%M:%S") ":  start fsarchive deploy dest ${4}"
  R=$(fsarchiver -o -j 2 -z 1 restfs ${2}/${3}.fsa id=0,dest=${4} 2>&1 )
  if ( [ $? -ne 0 ] )
  then
            echo "ERROR in deploying image"
            echo "${R}"
            exit 1
  fi
echo "${R}" > /tmp/fsarch.log
  echo $(date +"%H:%M:%S") ":  Finish fsarchive deploy"

}



case $1 in

  'clonePI')
      clonePI ${*}
      ;;
  'deployPI')
      deployPI ${*}
      ;;
  *)
   echo "Error:"  ${*};
esac;
