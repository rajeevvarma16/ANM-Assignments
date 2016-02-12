<!DOCTYPE html>
<html lang="en">
<head>
	<title>ASSIGNMENT-4</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
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
      $result = mysql_query("SELECT * FROM RESULTS ");
      ?>
<table class="table table-bordered" align="center" style="width:60%;padding-top:100px;border: 3px solid black;">
    <thead >
      <tr>
        <th>S.No</th>
        <th>IP</th>
        <th>PORT</th>
        <th>COMMUNITY</th>
       
        <th>DEVICE DETAILS</th>
        <th>DEVICE STATUS</th>
      </tr>
    </thead>
    <tbody >
  <?php
 while( $row = mysql_fetch_assoc( $result ) ){
if ($row['Lost_Packets'] == 1)
{
 $color = '#FFEEEE';
}
elseif($row['Lost_Packets'] >= 30)
{
$color = '#FF0000';
}

elseif($row['Lost_Packets'] == 2 || $row['Lost_Packets'] == 3)
{
$color = '#FFD9D9';
}
elseif($row['Lost_Packets'] == 4 || $row['Lost_Packets'] == 5)
{
$color = '#FFCCCC';
}
elseif($row['Lost_Packets'] == 6 || $row['Lost_Packets'] == 7)
{
$color = '#FFBFBF';
}
elseif($row['Lost_Packets'] == 8 || $row['Lost_Packets'] == 9)
{
$color = '#FFB2B2';
}
elseif($row['Lost_Packets'] == 10 || $row['Lost_Packets'] == 11)
{
$color = '#FFA6A6';
}
elseif($row['Lost_Packets'] == 12 || $row['Lost_Packets'] == 13)
{
$color = '#FF9999';
}
elseif($row['Lost_Packets'] == 14 || $row['Lost_Packets'] == 15)
{
$color = '#FF8C8C';
}
elseif($row['Lost_Packets'] == 16 || $row['Lost_Packets'] == 17)
{
$color = '#FF8080';
}
elseif($row['Lost_Packets'] == 18 || $row['Lost_Packets'] == 19)
{
$color = '#FF7373';
}
elseif($row['Lost_Packets'] == 20 || $row['Lost_Packets'] == 21)
{
$color = '#FF6666';
}
elseif($row['Lost_Packets'] == 22 || $row['Lost_Packets'] == 23)
{
$color = '#FF5959';
}
elseif($row['Lost_Packets'] == 24 || $row['Lost_Packets'] == 25)
{
$color = '#FF4D4D';
}
elseif($row['Lost_Packets'] == 26 || $row['Lost_Packets'] == 27)
{
$color = '#FF4040';
}
elseif($row['Lost_Packets'] == 28 || $row['Lost_Packets'] == 29)
{
$color = '#FF3333';
}
elseif($row['Lost_Packets'] == 0)
{
$color = '#FFFFFF';
}
echo
            "<tr>
           <td >{$row['id']}</td>
              <td>{$row['IP']}</td>
              <td>{$row['PORT']}</td>
              <td>{$row['COMMUNITY']}</td>
               <td><a href='details.php?var={$row['id']}'>click here</a></td>
              <td bgcolor='$color'>DEVICE STATUS</td>
               </tr>\n";
}
        ?>
      </tbody>
  </table>
</div>
</body>
</html>

//a comment
