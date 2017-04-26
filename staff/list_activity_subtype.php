<?php

require_once("connect.php");
require_once("model.php");
$act_type = $_GET["type"];
$begin_date = $_GET['begin_date'];
$end_date = $_GET['end_date'];
$connect = new DBConnect();
$mysqli = $connect->connect();

if (isset($_POST['act_id']) && isset($_POST['subtype']))
{
	$act_id = $_POST['act_id'];
	$subtype = $_POST['subtype'];
	//$sql_update_subtype = "UPDATE  activity SET act_subtype = $_POST['subtype']  WHERE act_id =$_POST['act_id'];";
	$sql_update_subtype = "UPDATE activity SET act_subtype = '$subtype' WHERE act_id = '$act_id'";
	if(Model::Query($mysqli, $sql_update_subtype))
	{}
}

	$beg_date="'".$begin_date." 00:00:00'";
	$endd_date="'".$end_date." 00:00:00'";
	Model::Query($mysqli, "SET @begin_time := $beg_date");
	Model::Query($mysqli, "SET @end_time := $endd_date");

$sql_subtype=
"
SELECT
*
FROM activity_subtype
WHERE 1
AND SUBSTRING(act_subtype,1,1) = $act_type
OR act_subtype = 0
;
";

$sql_list = 
"
SELECT 
a.act_id, 
a.act_title, 
a.act_location, 
a.act_begin_time, 
a.act_req_office, 
a.act_title, 
a.act_type,
a.act_subtype, 
b.act_type_name, 
c.act_subtype_name
FROM activity a, activity_type b, activity_subtype c
WHERE 1
AND a.act_type = b.act_type
AND a.act_subtype = c.act_subtype
AND a.act_type = $act_type
AND a.act_del = 0
AND a.act_post = 1
AND a.act_begin_time BETWEEN @begin_time AND @end_time
ORDER BY a.act_begin_time ASC,a.act_id,a.act_req_office
;
";
require_once("header.php");
?>
<style type="text/css">
    .div_list{
   		width: 1750px;
   	}
	.table_list th:nth-child(1){
    	width:50px;
    }
	.table_list th:nth-child(2){
    	width:85px;
    }
	.table_list th:nth-child(3){
    	width:260px;
    }
   
    .table_list th:nth-child(4){
    	width: 280px;
    }
    .table_list th:nth-child(5){
    	width: 75px;
    }
    .table_list th:nth-child(6)
	{
    	width: 50px;
    }
    .table_list th:nth-child(7)
	{
    	width: 150px;
    }
	
    .table_list th:nth-child(8),
    .table_list th:nth-child(9),
    .table_list th:nth-child(10),
    .table_list th:nth-child(11),
    .table_list th:nth-child(12){
    	width: 100px;
    }
    
    </style>
<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">日期設定</h3>
				格式：2015-08-01
			</div>
			<div class="panel-body">
				<form action="<?php echo $_SERVER['PHP_SELF'];?>">
					<input style="display:none" type="text" name="type" value="<?php echo $act_type;?>"/>
					起始日期<input type="text" name="begin_date" value="<?php echo $begin_date;?>"/><br>
					結束日期<input type="text" name="end_date" value="<?php echo $end_date;?>"/><br>
					<input type="submit" value="確定" class="btn btn-sm btn-default">
				</form>
			</div>
		</div>
	</div>	
		<div class="col-md-6 div_list">
			<table class="table table-condensed table_list">
				<thead>
					<tr>
						<th>活動編號</th>
						<th>辦理單位</th>
						<th>活動標題</th>
						<th>活動地點</th>
						<th>活動開始日期</th>
						<th>時數類別</th>
						<th>時數子類別</th>
						<th>
					</tr>
				</thead>
<?php
		
		if($result_list = Model::Query($mysqli, $sql_list))
		{
			while($list = Model::Fetch($result_list))
			{
			
echo <<<HEREDOC

            <tbody>
              <tr>
                <td><a name="$list->act_id"></a>$list->act_id</td>
				<td>$list->act_req_office</td>
                <td><a href="list_activity.php?act_id=$list->act_id">$list->act_title</a></td>
                <td>$list->act_location</td>
    			<td>$list->act_begin_time</td>
    			<td>$list->act_type_name</td>
HEREDOC;
				echo '<td><form method="POST" action='.$_SERVER['PHP_SELF'].'#'.$list->act_id.'><select name="subtype">';
				if($result_subtype = Model::Query($mysqli, $sql_subtype))
				{
					while($subtype = Model::Fetch($result_subtype))
					{
						if ($subtype->act_subtype == $list->act_subtype)
							$selected = 'selected="selected"';
						else
							$selected = '';
						echo '<option '.$selected.' value="'.$subtype->act_subtype.'">'.$subtype->act_subtype.' - '.$subtype->act_subtype_name.'</option>';
					}
				}
				echo '<input type="hidden" name="act_id" value="'.$list->act_id.'">';
				echo '</select>';
				echo '<input type="submit" class="btn btn-xs btn-default" value="修改">';
				echo '</form>';
				//<td><form action=""><input type="">$list->act_subtype_name</td>
              echo '</tr>';


			}
		}
		
        ?>
                    </tbody>
          </table>
        </div>	
        
</body>
</html>
