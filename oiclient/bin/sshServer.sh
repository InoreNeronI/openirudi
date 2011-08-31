#!/usr/bin/expect -d
set timeout 30

if { $argc != 5 } {
    puts "Wrong argument number"
    puts "sshServer.sh server user pass  rpath lpath"
    exit 1
}

#example of getting arguments passed from command line..
#not necessarily the best practice for passwords though...
set server [lindex $argv 0]
set user [lindex $argv 1]
set pass [lindex $argv 2]
set rpath [lindex $argv 3]
set lpath [lindex $argv 4]

puts "server: $server user: $user pass:  rpath: $rpath lpath: $lpath"

if { [catch { exec /bin/ls $lpath } results options ] } {
    puts "$lpath not found"
    if { [catch { exec /bin/mkdir $lpath } results options ] } {
        puts "$lpath not exist and I cant create"
        exit 1
   }
}

if { ! [catch { exec /bin/grep $lpath /proc/mounts } results options ] } {
    puts "$lpath is already mounted"
    exit 
}


# connect to server via ssh, login, and su to root
send_user "connecting to $server\n"

spawn -ignore HUP sshfs -C -o nonempty,reconnect,cache_timeout=5 $user@$server:$rpath $lpath

expect {
  -re ".*Are.*.*yes.*no.*" {
    send "yes\r"
    exp_continue
  }

  "password:" {
    send "$pass\r"
    exp_continue
  }
}

if { [catch { exec /bin/grep $lpath /proc/mounts } results options ] } {
    puts "NO mounted"
    exit 1
}
exit