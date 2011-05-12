#!/bin/bash


createDB(){

    set +e
    RES=$(echo "SHOW DATABASES;  " | mysql -h localhost -u $DBUSER -p$DBPWD 2>/dev/null )
    I=$(echo -e $RES |grep $DB )
    if [ -n "$I" ]
    then
        echo -e "\n${DB} exist and ${DBUSER} can access to it."
    else

      echo -e "\n${DB} not exist or ${DBUSER} can not access to it. I will try create ${DB} if not exist."
      CRE=$(echo "CREATE DATABASE ${DB} ;"  | mysql -h localhost -u $DBUSER -p$DBPWD 2>/dev/null )
      if [ $? != 0 ]
      then
        echo "${DBUSER} can't create ${DB} ."

        if [ -z "${ROOTUSER}" ]
        then
            rootUser
        fi

        RES=$(echo "SHOW DATABASES;  " | mysql -h localhost  -u $ROOTUSER -p$ROOTPWD 2>/dev/null )
        I=$(echo -e $RES |grep $DB )
        if [ -n "$I" ]
        then
            echo "${DB} exist !!"
        else
            CRE=$(echo "CREATE DATABASE ${DB} ;"  | mysql -h localhost -u $ROOTUSER -p$ROOTPWD )
            if [ $? != 0 ]
            then
                echo "${ROOTPWD} can't create DB."
                exit 1
            else
                echo "${DB} has been created."
            fi
        fi
      fi
    fi


    set -e
}

importDB(){

    set +e
echo "    mysql -h localhost -u ${DBUSER} -p${DBPWD} ${DB} < ${RPATH}/config/openirudiDB.sql"
    mysql -h localhost -u ${DBUSER} -p${DBPWD} ${DB} < ${RPATH}/config/openirudiDB.sql

    set -e
}

createDBUser(){

    set +e
    RES=$(echo "SHOW DATABASES;  " | mysql -h localhost -u $DBUSER -p$DBPWD 2>/dev/null )
    I=$(echo -e $RES |grep $DB )
    if [ -z "$I" ]
    then
        echo "${DBUSER} user can't access to ${DB} database. I will try create ${DBUSER} if not exist."

        if [ -z "${ROOTUSER}" ]
        then
            rootUser
        fi

        US=$(echo "use mysql; SELECT * FROM user WHERE user='${DBUSER}'" | mysql -h localhost -u $ROOTUSER -p$ROOTPWD )

        if [ -z "${US}" ]
        then
            US1=$(echo "CREATE USER '${DBUSER}'@'localhost' IDENTIFIED BY '${DBPWD}';" | mysql -h localhost -u $ROOTUSER -p$ROOTPWD )
            US2=$(echo "GRANT USAGE ON * . * TO '${DBUSER}'@'localhost' IDENTIFIED BY '${DBPWD}' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;" | mysql -h localhost -u $ROOTUSER -p$ROOTPWD )
        fi

        US3=$(echo "GRANT ALL PRIVILEGES ON ${DB} . * TO '$DBUSER'@'localhost' WITH GRANT OPTION ;" | mysql -h localhost -u $ROOTUSER -p$ROOTPWD )


    fi

    set -e

}

rootUser(){
    ROOTUSER='root'
    echo -e "Give me user with privileges to create  new database or new user? [${ROOTUSER}]"
    read BUF
    if [ -n "$BUF" ]
    then
      ROOTUSER="$BUF"
    fi

    ROOTPWD=''
    echo -e "Give me ${ROOTUSER}'s password?"

    trap "stty echo ; exit" 1 2 15
    stty -echo
    read BUF
    stty echo
    trap "" 1 2 15

    if [ -n "$BUF" ]
    then
      ROOTPWD="$BUF"
    fi


    RES=$(echo "SHOW DATABASES;  " | mysql -h localhost -u $ROOTUSER -p$ROOTPWD 2>/dev/null  )
    if [ $? != 0 ]
    then
      echo
      echo "I need user user with privileges to create new database or new user, but ${ROOTUSER} has not privileges."
      echo "I can no continue"
      exit 1
    fi


}

downloadLastClient(){
    APPYML="${WPATH}/apps/backend/config/app.yml"
    if [ ! -f $APPYML ]
    then
        echo "We not found config file ${APPYML}"
        exit 1
    fi

    LASTURL=$(cat $APPYML |grep lastClient: |awk '{print $2}' |tr -d "'" )
    LASTCLIENTV="$(wget -O /tmp/last.txt $LASTURL &>/dev/null )"
    if [ $? != 0 ]
    then
        echo "We can't connect to ${LASTURL} to download Openirudi client"
        exit 1
    fi
    LASTCLIENT="$(cat /tmp/last.txt |awk 'BEGIN { FS = "@@@" } ; {print $2}' )"

    ISOPATH=" ${WPATH}/$(cat $APPYML |grep isopath: |awk '{print $2}' |tr -d "'" )"
    CLIENTPATH=" ${WPATH}/$(cat $APPYML |grep clientpath: |awk '{print $2}' |tr -d "'")"


    ${WPATH}/bin/oiserver.sh update $LASTCLIENT $CLIENTPATH $ISOPATH
}


moveFiles(){
    echo "cp -a ${RPATH}  ${WPATH}"

    cp -a ${RPATH}  ${WPATH}
    parseDBuser
    symfonyInit


}

symfonyInit(){

    $WPATH/symfony cc
    $WPATH/symfony project:permissions
    chmod +x $WPATH/bin/*.sh


}

parseDBuser(){

    if [ -f /tmp/d1.yml ]
    then
      rm /tmp/d1.yml
    fi

    #${WPATH}/oiserver/config/databases.yml
    #dsn: 'mysql:dbname=drivers;host=localhost;unix_socket=/var/run/mysqld/mysqld.sock'
    #username: openirudi
    #password: openirudi

    cat ${WPATH}/config/databases.yml |sed "s/dsn\:.*$/dsn\: mysql:dbname=${DB};host=localhost;unix_socket=\/var\/run\/mysqld\/mysqld\.sock/" > /tmp/d1.yml
    mv /tmp/d1.yml ${WPATH}/config/databases.yml

    cat ${WPATH}/config/databases.yml |sed "s/username\:.*$/username\: ${DBUSER}/" | sed "s/password\:.*$/password\: ${DBPWD}/"  > /tmp/d1.yml
    mv /tmp/d1.yml ${WPATH}/config/databases.yml

    if [ -f /tmp/d1.yml ]
    then
      rm /tmp/d1.yml
    fi


    #$WPATH/oiserver/apps/backend/config/
    #  database: mysql://openirudi:openirudi@localhost/drivers

    cat ${WPATH}/apps/backend/config/factories.yml |sed "s/mysql\:\/\/.*$/mysql\:\/\/${DBUSER}:${DBPWD}@localhost\/${DB}/" > /tmp/d1.yml

    mv /tmp/d1.yml ${WPATH}/apps/backend/config/factories.yml

    if [ -f /tmp/d1.yml ]
    then
      rm /tmp/d1.yml
    fi


    #$WPATH/oiserver/web/func/dbcon.php
    #define('DB','openirudiDB');
    #define('DBUSER','openiridi');
    #define('DBPWD','openirudi');

    cat ${WPATH}/web/func/dbcon.php | sed "s/\$DB=.*$/\$DB=\'$DB\';/" |sed "s/\$DBUSER=.*$/\$DBUSER=\'$DBUSER\';/" | sed "s/\$DBPWD=.*$/\$DBPWD=\'$DBPWD\';/" > /tmp/d1.yml
    mv /tmp/d1.yml ${WPATH}/web/func/dbcon.php

    if [ -f /tmp/d1.yml ]
    then
      rm /tmp/d1.yml
    fi

}

createUser(){

    echo "We create openirudi user in server. We use this user to acces by ssh to upload or download image"
    set +e
    useradd  -c "Openirudi client user" openirudi
    set -e

}


######################################################
#
#       MAIN
#
#######################################################


set -e

RPATH="./oiserver"

echo -e "\nOPENIRUDI SERVER INSTALLER\n"
echo "Continue? (yes/NO)"
read CONTINUE

if [ "$CONTINUE" != "yes" ]
then
  echo "Abort Openirudi Instalation"
  echo "Agur..."
  echo
  exit
fi

INSTALLER=$0
IPATH=$(dirname "${INSTALLER}");
if [ "$(pwd )" != "${IPATH}" ]
then
    cd $IPATH
fi


ROOTUSER=''
ROOTPWD=''

GENISOIMAGE=$(which genisoimage)
if [ $? != 0 ]
then
  echo -e "\nHave you genisoimage installed?"
  echo
  exit 1
fi

GENISOIMAGE=$(which mysql)
if [ $? != 0 ]
then
  echo -e "\nHave you mysql client installed?"
  echo
  exit 1
fi



PHP=$(which php)
if [ $? != 0 ]
then
  echo "Have you php installed?"
  echo
  exit 1
fi

WEB=$(wget -O /dev/null http://localhost &>/dev/null)
if [ $? != 0 ]
then
  echo "ERROR: Have you web server installed?"
  echo "We not found http://localhost in your server"
  echo
  exit 1
fi

WPATH='/var/www/'
echo -e "\nGive me Openirudi's root path? [${WPATH}]"
read BUF
if [ -n "$BUF" ]
then
  WPATH="$BUF"
fi

if [ ! -d "$WPATH" ]
then
    echo "$WPATH is no valid path. Exist?"
    echo "We can't continue!"
    exit 1
fi

WPATH="${WPATH}/oiserver"


DB='openirudiDB'
echo -e "\nGive me Openirudi's DB? [${DB}]"
read BUF
if [ -n "$BUF" ]
then
  DB="$BUF"
fi

DBUSER='openirudi'
echo -e "Give me database user to access to ${DB} database? [${DBUSER}]"
read BUF
if [ -n "$BUF" ]
then
  DBUSER="$BUF"
fi

DBPWD='openirudi'
echo -e "Give me ${DBUSER}'s password to access to ${DB}?"

trap "stty echo ; exit" 1 2 15
stty -echo
read BUF
stty echo
trap "" 1 2 15

if [ -n "$BUF" ]
then
  DBPWD="$BUF"
fi

set +e
RES=$(echo "SHOW DATABASES;  " | mysql -h localhost -u$DBUSER -p$DBPWD &>/dev/null )
if [ $? != 0 ]
then
  echo -e "\nI can't query DB. May be \"${DBUSER}\" not exists yet."
fi
set -e


echo
echo "*Create database"
createDB

echo
echo "*Create database user"
createDBUser

echo
echo "*Create system user"
createUser

echo
echo "*Import database content"
importDB

echo
echo "*Move files"
moveFiles

echo
echo "*Download last client"
downloadLastClient


echo -e "\n\n\n"

echo "We need ssh server to upload/download images."
if [ -z "$(netstat -lnpt 2>&1 |grep tcp|grep ':22' )" ]
then
    echo "You not have SSH sever installed or is not correctly configured."
    echo "In Debian or Ubuntu to install ssh server \"apt-get install ssh\""
else
    echo "You have ssh sever running"
fi


echo -e "\n\n\n"

echo "Your turn!"
echo "*1/3 TFTP SERVER:"
echo -e "\tWe need tftp server to boot with pxe."
if [ -z "$(netstat -lnpu 2>&1 |grep udp|grep ':69' )" ]
then
    echo -e "\tYou not have tftp sever installed or is not correctly configured."
    echo -e "\tIn Debian or Ubuntu to install tftp server \"apt-get install atftpd\""
else
    echo "\tYou have tftp sever running"
fi

echo "\tConfigure \"${WPATH}/web/func/root\"  as tftp server path"

echo "*2/3 SUDO:"
echo -e "\tWe need execute \"oiserver.sh\" as root."
echo -t "\tExecute visudo and add folowing lines(We supossed www-data is web server user):"

echo -e "\t\tCmnd_Alias CMDOPENIRUDI = /home/aitor/kodea/oiserver/bin/oiserver.sh"
echo -e "\t\twww-data ALL = NOPASSWD: CMDOPENIRUDI"


echo -e "\n\n\n"



echo "Openirudi's server is sucesfully installed. Don't forget to configure your tftp server."
echo "Agur..."
