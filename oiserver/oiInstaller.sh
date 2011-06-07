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
                echo "${ROOTPWD} can't create Database."
                exit 1
            else
                echo "${DB} has been created succesfully."
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

addCron(){
    CMD="* * * * * wget -O /dev/null http://localhost/oiserver/web/func/wakeUp.php &> /dev/null"
    cat <(crontab -l|grep -v wakeUp.php ) <(echo "${CMD}") | crontab -
}

addSudo(){

    if [ -f /tmp/sudoers.tmp ]
    then
        rm /tmp/sudoers.tmp
    fi

    cat /etc/sudoers | grep -v CMDOPENIRUDI | grep -v OpenIrudi > /tmp/sudoers.tmp

    echo "# OpenIrudi" >> /tmp/sudoers.tmp
    echo "Cmnd_Alias CMDOPENIRUDI = /var/www/oiserver/bin/oiserver.sh" >> /tmp/sudoers.tmp
    echo "www-data ALL = NOPASSWD: CMDOPENIRUDI" >> /tmp/sudoers.tmp

    visudo -c -f /tmp/sudoers.tmp
    if [ "$?" -eq 0 ];
    then
        cp /tmp/sudoers.tmp /etc/sudoers
    fi

    rm /tmp/sudoers.tmp

}


createDBUser(){

    set +e
    RES=$(echo "SHOW DATABASES;  " | mysql -h localhost -u $DBUSER -p$DBPWD 2>/dev/null )
    I=$(echo -e $RES |grep $DB )
    if [ -z "$I" ]
    then
        echo "${DBUSER} user can't access to ${DB} database. I will try to create ${DBUSER} if does not exist."

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
    echo -e "Username of user with admin privileges in a database: [${ROOTUSER}]"
    read BUF
    if [ -n "$BUF" ]
    then
      ROOTUSER="$BUF"
    fi

    ROOTPWD=''
    echo -e "${ROOTUSER} Password:"

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
      echo "Introduced data is incorrect, please retry with a different user or password, ${ROOTUSER} has not privileges."
      echo "Proccess Stopped"
      exit 1
    fi


}

downloadLastClient(){
    APPYML="${WPATH}/apps/backend/config/app.yml"
    if [ ! -f $APPYML ]
    then
        echo "I could not open config file ${APPYML}"
        exit 1
    fi

    LASTURL=$(cat $APPYML |grep lastClient: |awk '{print $2}' |tr -d "'" )
    LASTCLIENTV="$(wget -O /tmp/last.txt $LASTURL &>/dev/null )"
    if [ $? != 0 ]
    then
        echo "We can't connect and download Openirudi client from ${LASTURL}"
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

    echo "Creating an ssh user on server size, please wait... we need this user for images upload/download tasks"
    set +e
    if [ -n "$(id openirudi)" ]
    then
        useradd  -m -c "Openirudi client user" openirudi
    fi
    set -e

}


######################################################
#
#       MAIN
#
#######################################################


set +e

RPATH="./oiserver"

echo -e "\nOPENIRUDI SERVER INSTALLATION\n"
echo "Would you like to continue? (yes/NO)"
read CONTINUE

if [ "$CONTINUE" != "yes" ]
then
  echo "Abort Openirudi Installation"
  echo "Agur benur eta jan yogurth..."
  echo
  exit
fi

echo "path berria"
INSTALLER=$0
IPATH=$(dirname "${INSTALLER}");
if [ "$(pwd )" != "${IPATH}" ]
then
    cd $IPATH
fi


ROOTUSER=''
ROOTPWD=''

echo "ea genisoimage badagoen"
GENISOIMAGE=$(which genisoimage)
if [ $? != 0 ]
then
  echo -e "\ngenisoimage not present!"
  echo
  exit 1
fi

echo "ea mysql badagoen"
GENISOIMAGE=$(which mysql)
if [ $? != 0 ]
then
  echo -e "\nmysql client not present!"
  echo
  exit 1
fi

echo "ea sudo badagoen"
SUDO=$(which sudo)
if [ $? != 0 ]
then
  echo -e "\nOpenIrudi's sever needs \"sudo\" to execute oiserver.sh. Install "sudo" and run installer again!"
  echo
  exit 1
fi


echo "ea php badagoen"
PHP=$(which php)
if [ $? != 0 ]
then
  echo "php not present!"
  echo "You need php5-cli"
  echo
  exit 1
fi

echo "ea apache martxan dagoen"

WEB=$(wget -O /dev/null http://localhost &>/dev/null)
if [ $? != 0 ]
then
  echo "ERROR: Web server not present!"
  echo "We couldn't find http://localhost in your server"
  echo
  exit 1
fi

WPATH='/var/www/'
echo -e "\nInstallation path: [${WPATH}]"
read BUF
if [ -n "$BUF" ]
then
  WPATH="$BUF"
fi

if [ ! -d "$WPATH" ]
then
    echo "$WPATH doesn't exist or you don't have permissions?"
    echo "Abort Openirudi Installation"
    exit 1
fi

WPATH="${WPATH}oiserver"


DB='openirudiDB'
echo -e "\nDatabase name: [${DB}]"
read BUF
if [ -n "$BUF" ]
then
  DB="$BUF"
fi

DBUSER='openirudi'
echo -e "${DB} database username: [${DBUSER}]"
read BUF
if [ -n "$BUF" ]
then
  DBUSER="$BUF"
fi

DBPWD='openirudi'
echo -e "${DBUSER} user password for ${DB}?"

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
echo "*Add new entry in sudoers file"
addSudo

echo
echo "*Add new job to crontab"
addCron

echo
echo "*Downloading lastest Openirudi client"
downloadLastClient


echo -e "\n\n\n"
echo "*** Important: You need SSH and TFTP servers running to enjoy properly from Openirudi. ***"

echo "Checking if ssh server is present."
if [ -z "$(netstat -lnpt 2>&1 |grep tcp|grep ':22' )" ]
then
    echo "You don't have SSH sever installed or is not running."
    echo "(Debian or Ubuntu) install it with the following command \"apt-get install ssh\""
else
    echo "ssh sever is running"
fi


echo -e "\n\n\n"

echo "Checking if tftp server is present."
if [ -z "$(netstat -lnpu 2>&1 |grep udp|grep ':69' )" ]
then
    echo "You don't have tftp sever installed, runnig or you didn't configure properly."
    echo "(Debian or Ubuntu) install it with the following command \"apt-get install atftpd\""
else
    echo "tftp sever is running"
fi

echo "*** Remember to configure \"${WPATH}/web/func/root\"  as tftp server path. ****"

echo -e "\n\n\n"



echo "Openirudi's server is sucesfully installed. Don't forget to configure your tftp server"

echo "You can start managing Openirudi via web from: http://localhost/oiserver
user: admin
pass: admin"


echo "Enjoy!"
