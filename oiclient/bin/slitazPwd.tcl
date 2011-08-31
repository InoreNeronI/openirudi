#!/usr/local/bin/expect --
# wrapper to make passwd(1) be non-interactive
# username is passed as 1st arg, passwd as 2nd
# Executable only by root

puts "\nchange password  user: [lindex $argv 0]"

set user [lindex $argv 0]
set password [lindex $argv 1]

set success 0
set timeout 5

spawn /usr/bin/passwd $user
set spid $spawn_id
expect -i $spid \
          "New password:"      {
                        exp_send -i $spid "${password}\r"
                        if { $success == 0 } {
                                incr success -1
                                exp_continue
                        }
       
        } "Retype password:"  {
                exp_send -i $spid "${password}\r"
                        if { $success == 0 } {
                                incr success -1
                                exp_continue
                        }
        } timeout       {
                set success -1
        }

exp_wait -i $spid
exp_close -i $spid

exit


