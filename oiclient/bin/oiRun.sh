#!/bin/sh
#
# /etc/init.d/oiRun.sh:  openirudi client services,
#
#
#

NAME=OpenIrudi
DESC="Openirudi client services"

LOG=/tmp/oiRun.log
AUTOSTART=/home/tux/.config/openbox/autostart.sh

if [ -f ${LOG} ]
then
    rm ${LOG}
fi

if [ -n "$(ip link |grep eth0 |grep UP )" ]
then
    COUNT=0
    while [ -z "$(ifconfig | grep 'inet addr:' | awk '{print $2}'|grep -v 'addr:127' )" ] && [ $COUNT -lt 10 ]
    do
        COUNT=$(expr $COUNT + 1 )
        echo "$(date) count $COUNT no ip yet " >> $LOG
        sleep 2
    done
fi

echo "ip: $(ifconfig | grep 'inet addr:' | awk '{print $2}'|grep -v 'addr:127' )" >> $LOG


echo "$(date +"%H:%M:%S") Start oiRun2" > ${LOG}

echo "$(date +"%H:%M:%S") setInitParams" >> ${LOG}
R=$(/var/www/openirudi/bin/slitazConfig.sh setInitParams )
echo "result:: ${R}" >> ${LOG}
cat /var/www/openirudi/cache/openirudi.yml >> ${LOG}


echo "$(date +"%H:%M:%S") start lighttpd $(date +"%H:%M:%S") pid:: $(pidof lighttpd)" >> ${LOG}
while [ -z "$(pidof lighttpd)" ];
do
 
    rm  /var/run/lighttpd.pid
    /etc/init.d/lighttpd start
    sleep 1
    echo "$(date +"%H:%M:%S") start lighttpd $(date +"%H:%M:%S") pid:: $(pidof lighttpd)" >> ${LOG}
done

echo "$(date +"%H:%M:%S") started lighttpd $(date +"%H:%M:%S") pid:: $(pidof lighttpd)" >> ${LOG}





exit 0
