<!DOCTYPE html>
<html lang="en">
<head>
<TITLE>ASSIGNMENT-4</TITLE>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<style></style>
</head>
<body>
<div class="page-header" ALIGN='CENTER' >
    <h1>ASSIGNMENT-4</h1>      
  </div>
<div style="background-color:white;height:1000px;padding-top: 25px;">
<?php


//Finding path to 'db.conf'
	$cpath = __FILE__;
	$split_arr = explode('/', $cpath);
	array_splice($split_arr, -2, count($split_arr), array('db.conf'));
	$real_path = implode('/', $split_arr);
	
	$file_handle = fopen($real_path, "r") or die("Unable to open file!");

//Getting one line at a time until end of file (EOF) is reached
	while(!feof($file_handle))
	{
		$line = fgets($file_handle);
		$tline = trim($line);
	  
		if(substr($tline, 0, 1) === '$')
		{
			$variable_line = explode('=', $tline);
			$variable = trim($variable_line[0]);
			$value = explode('"', $variable_line[1]);
			
			if($variable === '$host')
			{
				$host = trim($value[1]);
			}
			
			elseif($variable === '$port')
			{
				$port = trim($value[1]);
			}
			
			elseif($variable === '$database')
			{
				$database = trim($value[1]);
			}
			
			elseif($variable === '$username')
			{
				$username = trim($value[1]);
			}
			
			else
			{
				$password = trim($value[1]);
			}
		}
		
		else
		{
			continue;
		}
	}
	
	fclose($file_handle);
//print "\n" . $host . "\n" . $port . "\n" . $database . "\n" . $username . "\n" . $password . "\n";


$connector = mysql_connect($host,$username,$password)
          or die("Unable to connect");
       
      $selected = mysql_select_db("$database", $connector)
        or die("Unable to connect");
   

      //execute the SQL query and return records
      
      ?>
<table class="table table-bordered" align="center" style="width:50%;padding-top:100px;">
    <thead >
      <tr >
        <th>S.No</th>
        <th>IP</th>
          <th>SYSUPTIME</th>
        <th>SENT REQUESTS</th>
        <th>TOTAL LOST REQUESTS</th>
        <th >WEB SERVER TIME</th>
      </tr>
    </thead>
    <tbody >
      
  <?php
if(isset($_REQUEST['var']))
{
 $x=$_REQUEST['var'];
$result = mysql_query("SELECT * FROM RESULTS where id='$x'");

         $row = mysql_fetch_assoc( $result );
            echo
            "<tr>
              <td>{$row['id']}</td>
              <td>{$row['IP']}</td>
              <td>{$row['SysUpTime']}</td>
              <td>{$row['Sent_Packets']}</td>
              <td>{$row['Total_Lost_packets']}</td>
              <td >{$row['Server_time']}</td>
               </tr>\n";
          }
        ?>
      
</tbody>
  </table>

</div>
</body>
</html>
