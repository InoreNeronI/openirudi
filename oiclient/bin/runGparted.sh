#!/bin/sh -e

echo "----------" > /tmp/aa.log

A=$(xdotool search "Firefox" )
echo -e "\n---1--- ${A}" >> /tmp/aa.log

B=$(xdotool search "Gparted" )
echo -e "\n---2--- ${B}" >> /tmp/aa.log

echo -e ".-.-.-.-.-";
exit;



if [ -z "${A}" ];
then
    echo "Ez dago Gparted..." >> /tmp/aa.log
    DISPLAY=:0.0 sudo /usr/sbin/gparted
    sleep 1
else
    echo "BADAGO........." >> /tmp/aa.log
fi

echo "----------------------" >> /tmp/aa.log
DISPLAY=:0.0 sudo xdotool windowactivate $(sudo xdotool search "GParted" | head -1)
DISPLAY=:0.0 sudo xdotool windowsize $(sudo xdotool search "GParted" | head -1) 800 600

echo "--------------1---------" >> /tmp/aa.log
