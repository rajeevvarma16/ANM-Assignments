#!/usr/bin/perl
use Net::SNMP;
use DBD::mysql;
use DBI;
use Cwd ;
$cwd = cwd();

@array = split("/",$cwd);
pop(@array);
push(@array,"db.conf");
$finalpath = join("/",@array);

require "$finalpath";

my $time = localtime();
#connect to the database file

$dbh= DBI->connect("DBI:mysql:database=$database;host=$host",  $username, $password);

$sth = $dbh->prepare("SELECT * FROM DEVICES");#retrieving values from devices
$sth->execute();

#creating table to show the results
$dbh->do("CREATE TABLE IF NOT EXISTS RESULTS (id INT PRIMARY KEY AUTO_INCREMENT, IP VARCHAR(255) NOT NULL, PORT INT(11) NOT NULL, COMMUNITY VARCHAR(200) NOT NULL, SysUpTime VARCHAR(2000) DEFAULT '', Sent_Packets INT DEFAULT 0, Lost_Packets INT DEFAULT 0,Total_Lost_packets INT DEFAULT 0, Server_time VARCHAR(100), UNIQUE KEY (IP,PORT,COMMUNITY))");
$dbh->do("INSERT INTO RESULTS (IP, PORT, COMMUNITY) SELECT DEVICES.IP, DEVICES.PORT, DEVICES.COMMUNITY FROM DEVICES ON DUPLICATE KEY UPDATE IP= RESULTS.IP  ");

while (my $ref = $sth->fetchrow_hashref()) {
my $ip = $ref->{'IP'};
my $community = $ref->{'COMMUNITY'};
my $port = $ref->{'PORT'};
my ($session, $error) = Net::SNMP->session(
         -hostname    => $ip,
         -community   => $community,
         -nonblocking => 1,
         -port 	      => $port,
          );
         if (!defined $session) {
         printf "ERROR: Failed to create session for host '%s': %s.\n",
                $ip, $error;
         next;
           }
        my $result = $session->get_request(
         -varbindlist => [ '1.3.6.1.2.1.1.3.0' ],
         -callback    => [ \&get_callback, $ip, $port, $community, $time ],
          );
      if (!defined $result) {
         printf "ERROR: Failed to queue get request for host '%s': %s.\n",
                $session->hostname(), $session->error();
}
}$sth->finish();
# Now initiate the SNMP message exchange.
snmp_dispatcher();
exit 0;
sub get_callback
   {

 my ($session, $ip, $port, $community) = @_;
 my $result = $session->var_bind_list();
if (!defined $result) {
     printf "ERROR: Get request failed for host '%s': %s.\n",
      $session->hostname(), $session->error();
          $dbh->do("UPDATE RESULTS SET  SysUpTime= SysUpTime, Sent_packets=Sent_packets+1, Lost_Packets= Lost_Packets+1, Total_Lost_Packets=Total_Lost_packets+1, Server_time='$time' WHERE  IP='$ip' AND PORT='$port' AND COMMUNITY='$community' ");
         return;
      }
printf "The sysUpTime for host '%s' is %s .\n",
$session->hostname(), $result->{'1.3.6.1.2.1.1.3.0'};
$dbh->do("UPDATE RESULTS SET  SysUpTime='$result->{'1.3.6.1.2.1.1.3.0'}', Sent_packets=Sent_packets+1, Lost_Packets= 0, Total_Lost_Packets=Total_Lost_packets, Server_time='$time' WHERE  IP='$ip' AND PORT='$port' AND COMMUNITY='$community' ");
return;
}



 

    

  





  
      















 
