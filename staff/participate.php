<div align="center">
<?
require_once("header.php");
require_once("connect.php");
require_once("model.php");

$conn = new mysqli($servername, $dbaccount, $dbpassword, $dbname);
if ($conn->connect_error) {    die("Connection failed: " . $conn->connect_error);} 
/*
$sql1="
DROP TABLE IF EXISTS participate;";
if (!$conn->query($sql1) === TRUE) 
 {    echo "Error droping table: " . $conn->error ."<br>";}
$sql2="CREATE TABLE participate 
(
  id int(20) NOT NULL,
  act_id int(20) NOT NULL,
  act_type tinyint(4) DEFAULT NULL,
  user_student int(20) NOT NULL,
  basic_hour smallint(5) DEFAULT NULL,
  adv_hour smallint(5) DEFAULT NULL,
  verity_stu int(20) DEFAULT NULL,
  edit_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) 
ENGINE=MyISAM DEFAULT CHARSET=utf8;";
if (!$conn->query($sql2) === TRUE) 
 {    echo "Error creating table: " . $conn->error ."<br>";}
$sql3="
 ALTER TABLE participate
 ADD PRIMARY KEY (id,act_id,user_student),
 ADD UNIQUE (act_id,user_student),
 MODIFY id int(20) NOT NULL AUTO_INCREMENT
 ;
 ";
 if (!$conn->query($sql3) === TRUE) 
 {    echo "Error setting table: " . $conn->error ."<br>";}
 
*/
/*	
$sql1="
DROP TABLE IF EXISTS participate_out  ;";
if (!$conn->query($sql1) === TRUE) 
 {    echo "Error droping table: " . $conn->error ."<br>";}
$sql2="
CREATE TABLE participate_out   (
	id int(20) NOT NULL,
   act_id   int(20) NOT NULL,
   act_type   tinyint(4) DEFAULT NULL,
   user_student   int(20) NOT NULL,
   basic_hour   smallint(5) DEFAULT NULL,
   adv_hour   smallint(5) DEFAULT NULL,
   verity_stu   int(20) DEFAULT NULL,
   edit_time   timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
if (!$conn->query($sql2) === TRUE) 
 {    echo "Error creating table: " . $conn->error ."<br>";}
$sql3="
ALTER TABLE participate_out
 ADD PRIMARY KEY (id , act_id , user_student),
 ADD UNIQUE (act_id,user_student),
 MODIFY id int(20) NOT NULL AUTO_INCREMENT;
 ";
	 if (!$conn->query($sql3) === TRUE) 
 {    echo "Error setting table: " . $conn->error ."<br>";}
	
*/	
	$from_table = 'activity';
	$insert_table = 'participate';
	
	
	
	$sql = "SELECT * FROM `$from_table` where act_del = 0";

	$time_start = microtime(true);
	
	$connect = new DBConnect;
	$mysqli = $connect->connect();
	
	$result = $mysqli->query($sql);
	while($row = $result->fetch_assoc())
	{
		$act_admit_student = $row['act_admit_student'];
		$act_id = $row['act_id'];
		$stu_array = explode(",",$act_admit_student);
		$array_size = sizeof($stu_array);

		if(strlen($act_admit_student) != 0)
		{

			for($i=0;$i<$array_size;$i++)
			{
				/*$sql_c = "SELECT `act_id`,`user_student` FROM $insert_table
				WHERE `act_id`=$act_id AND `user_student`=$stu_array[$i]; ";
				$ret = mysqli_query($conn,$sql_c) or die(mysqli_error($conn));
				$cnt = mysqli_num_rows($conn,$ret);
				if(!cnt>0)
				{*/
					$sql_i = "INSERT INTO $insert_table(id,`act_id`,`user_student`) VALUES(NULL,$act_id,$stu_array[$i])";
					if(!$mysqli->query($sql_i))
					{
					//echo "Insert action is failed: act_id=$act_id,user_student=$stu_array[$i]<p>$mysqli->error<p>";
					}
				/*}*/
			}
		}
	}
	
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	echo "<p>更新".$insert_table."完成";
	echo "執行時間:".$time."<BR>";
	
	
	$from_table = 'out_activity';
	$insert_table = 'participate_out';
	
	
	$sql = "SELECT * FROM `$from_table` where act_del = 0";

	$time_start = microtime(true);

	$connect = new DBConnect;
	$mysqli = $connect->connect();
	

	$result = $mysqli->query($sql);
	while($row = $result->fetch_assoc())
	{
		$adv_hour = "NULL";
		$basic_hour = "NULL";
		
		$act_pass_type = $row['act_pass_type'];
		$act_service_hour = $row['act_service_hour'];
		$act_admit_student = $row['act_admit_student'];
		$act_id = $row['act_id'];
		$stu_array = explode(",",$act_admit_student);
		$array_size = sizeof($stu_array);

		
		$hour_array = explode(",",$act_service_hour);
		$hour_array_size = sizeof($hour_array);
		
		if($hour_array_size > 2)
		{
			echo "the act_service_hour coulumn is error where the act_id = $act_id";
			exit;
		}
		elseif($hour_array_size == 1)
		{
			switch($act_pass_type)
			{
				case 1:
					$basic_hour = $act_service_hour;
					break;
				case 2:
					$adv_hour = $act_service_hour;
					break;
				case 3:
					$basic_hour = $hour_array[0];
					if(isset($hour_array[1]))
						$adv_hour = $hour_array[1];
					break;
			}
		}
		elseif($hour_array_size == 2)
		{
			$basic_hour = $hour_array[0];
			if(isset($hour_array[1]))
				$adv_hour = $hour_array[1];
		}
		else
		{
			echo "there are something wrong where the program execute the part of checking hours.";
			exit;
		}
			
		


		
		if(strlen($act_admit_student) != 0)
		{
			for($i=0;$i<$array_size;$i++)
			{
				/*$sql_c = "SELECT `act_id`,`user_student` FROM $insert_table
				WHERE `act_id`=$act_id AND `user_student`=$stu_array[$i]; ";
				$ret = mysqli_query($conn,$sql_c) or die(mysqli_error($conn));
				$cnt = mysqli_num_rows($conn,$ret);
				if(!cnt>0)
				{*/
					$sql_i = "INSERT INTO $insert_table(id,`act_id`,`user_student`,`basic_hour`,`adv_hour`) VALUES(NULL,$act_id,$stu_array[$i],$basic_hour,$adv_hour)";
					if(!$mysqli->query($sql_i))
					{						
						//echo "Insert action is failed: act_id=$act_id,user_student=$stu_array[$i]<p>$mysqli->error<p>";
					}					
				/*}*/
			}
		}

	}
	
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	echo "<p>更新".$insert_table."完成";
	echo "執行時間:".$time."<br>";
	?>
	</div >