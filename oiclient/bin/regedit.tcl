#!/usr/bin/expect


#http://www.geoffchappell.com/
#http://www.multibooters.co.uk/mbr.html


proc regeditCmd { cmdList } {
  global  HIVE_FILE
  set timeout 5
  spawn /usr/sbin/reged -e $HIVE_FILE
  set spid $spawn_id
    foreach cmd $cmdList {
    puts "\n\n---------CMD: $cmd \n\n"
    expect {

	"\n>" {
	  puts "\nSEND1:: $cmd"
	  send -- "$cmd\r"
	  continue
	}

        "\n->" {
	  puts "\nSEND1b:: $cmd"
          send -- "$cmd\r"
	  continue
	}

	"\n\\\\*>" {
	  puts "\nSEND2:: $cmd"
	  send -- "$cmd\r"
	  continue
	}

	"\n(...)\\\\*>" {
	  puts "\nSEND3:: $cmd"
	  send -- "$cmd\r"
	  continue
	}

	"\nNew length (ENTER to keep same): " {
	  puts "\nSEND4::\n"
	  send "\r"
	  exp_continue
	}

	"\n\." {
	  puts "\nSEND5::$cmd\n"
	  send "$cmd\r"
	  continue
	}

	"\nCommit changes to registry? (y/n)*: " {
	  puts "\nSEND6::y\n"
	  send "y\r"
	  expect "closing"
	  break
	}

    }
  }
  exp_wait -i $spid
  #exp_close -i $spid

  if { [catch {exp_close -i $spid } return ] } {
            puts stderr "close HIVE \n$return"
  }


}


set CMDFILE "/tmp/regedit.cmd"
set CMDS { }

puts "\ncc: $argc"

if { $argc != 1 } {
    puts "\nERROR command must be $argv0 HIVE_FILE"
    exit 1
}

set HIVE_FILE [lindex $argv 0 ]

puts "\nHIVE:: $HIVE_FILE   ss: [file readable $HIVE_FILE ] "


if { [file readable $HIVE_FILE ] == 0 } {
    puts "\nHIVE FILE:: $HIVE_FILE not readable"
    exit 1
}



if { [file readable $CMDFILE ] } {
    set CMDSF [open $CMDFILE r]
    while { [gets $CMDSF CMD ] != -1 } {
        
        if {  [string length $CMD ] == 0  } {
            continue
        }
        lappend CMDS $CMD 
    }
} else {
    puts "\ncmd file not readable\n"
}


if { [llength $CMDS ] > 0 } {
    lappend CMDS "q"
    lappend CMDS "-"
    
    if { [catch {regeditCmd $CMDS } return ] } {
            puts stderr "Error executing\n$CMDS\n$return"
            #exit 1
    }

}

#set values {ls "cd Objects\\{9dea862c-5cdd-4e70-acc1-f32b344d4795}\\Elements\\11000001" "ed Element" ": 00 44 44 44" "s" "q" "-" }
#set values {ls "q" "-" }
#regeditCmd $values

puts "\n...\n"


