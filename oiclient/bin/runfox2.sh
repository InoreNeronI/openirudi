#! /bin/sh

LOG=/tmp/runfox2.log

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

echo "$(date +"%H:%M:%S"):: Start ";

while [ -z "$(pidof midori)" ];
do
    echo "$(date +"%H:%M:%S") :: start midori11" >> ${LOG}
    echo "start midori $(date +"%H:%M:%S")"
    rm /etc/midori_config_w/*.xbel
    rm /etc/midori_config_w/*.db

    /usr/bin/midori -c /etc/midori_config_w http://localhost/index.php &
    echo "$(date +"%H:%M:%S") :: pid midori:: $(pidof midori) " >> ${LOG}
    sleep 1
done

echo "$(date +"%H:%M:%S") :: all started " >> ${LOG}

WINDOW=$(/usr/bin/xdotool search "Midori" | head -1)
if [ -n "${WINDOW}" ]
then
    echo "$(date +"%H:%M:%S") :: midori window ${WINDOW}" >> ${LOG}
    /usr/bin/xdotool windowactivate ${WINDOW}
    /usr/bin/xdotool windowfocus ${WINDOW}
    echo "focus: ".$(/usr/bin/xdotool windowfocus ${WINDOW} ) >> ${LOG}
    #/usr/bin/xdotool key F11
else
    echo "I not detetect Midori window" >> ${LOG}
fi

echo "$(date +"%H:%M:%S") :: pid midori:: $(pidof midori) window ${WINDOW}" >> ${LOG}

echo "midori is running $(pidof midori)"
echo "$(date +"%H:%M:%S") :: midori is running $(pidof midori) " >> ${LOG}
