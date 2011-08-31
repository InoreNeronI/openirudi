#!/bin/sh



if [ $# -ne 1  ]; then
        echo "we expect: $0 (server)";
        exit 1
fi

SERVER=$1

rsync -Cavz aitor@${SERVER}:/home/aitor/kodea/openirudi/* /var/www/openirudi/
if ( ! [ $? -eq 0 ] )
then
	echo "I can't rsync with server"
	exit 1;
fi

/var/www/openirudi/symfony cc
/var/www/openirudi/symfony project:permissions
chmod +x /var/www/openirudi/bin/*.sh


