#!/usr/bin/perl
use Net::SNMP;
use DBD::mysql;
use DBI;
use Net::SNMP;

while(1){

$time1 = time();
 `perl ./backend.pl`;
 $time2 = time();
 $t = $time2-$time1;
 if($t<=30)
 {
  sleep(30-$t);
 }

}
#comment
