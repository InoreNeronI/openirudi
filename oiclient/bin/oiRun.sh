#!/bin/sh
#
# /etc/init.d/oiRun.sh:  openirudi client services,
#
#
#

echo "ip: $(ifconfig | grep 'inet addr:' | awk '{print $2}'|grep -v 'addr:127' )"
echo "$(date +"%H:%M:%S") Start oiRun2" 
echo "$(date +"%H:%M:%S") setInitParams" 

R=$(/var/www/openirudi/bin/slitazConfig.sh setInitParams )
echo "result:: ${R}" 
cat /var/www/openirudi/cache/openirudi.yml 


echo "$(date +"%H:%M:%S") start lighttpd $(date +"%H:%M:%S") pid:: $(pidof lighttpd)" 
while [ -z "$(pidof lighttpd)" ];
do
    echo "EZ DAGO lighttpd !!!!!!!!!!!!!!!!!"
    rm  /var/run/lighttpd.pid
    /etc/init.d/lighttpd start
    sleep 1
    echo "$(date +"%H:%M:%S") start lighttpd $(date +"%H:%M:%S") pid:: $(pidof lighttpd)" 
done

echo "$(date +"%H:%M:%S") started lighttpd $(date +"%H:%M:%S") pid:: $(pidof lighttpd)"



