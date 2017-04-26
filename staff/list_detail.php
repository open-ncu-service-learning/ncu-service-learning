<?php
require_once("connect.php");
require_once("model.php");
require_once("header.php");
$connect = new DBConnect();
$mysqli = $connect->connect();

if(isset($_GET['student']))
	$user_student = $_GET['student'];
else
	$user_student = FALSE;


$sql_list_detail = 
"
SELECT a.user_student, a.user_name, a.user_sex, a.user_dep,user_identity , b.act_id, b.act_title, b.act_begin_time, d.act_pass_type_name, e.act_type, e.act_type_name, b.act_service_hour, c.basic_hour, c.adv_hour 
FROM all_user a, activity b, participate c, activity_pass_type d, activity_type e
WHERE 1
and a.user_student = c.user_student
and b.act_id = c.act_id
and b.act_del = 0
and b.act_pass_type = d.act_pass_type
and b.act_type = e.act_type
and a.user_student = $user_student
UNION
SELECT a.user_student, a.user_name, a.user_sex, a.user_dep, user_identity, b.act_id, b.act_title, b.act_begin_time, d.act_pass_type_name, e.act_type, e.act_type_name, b.act_service_hour, c.basic_hour, c.adv_hour 
FROM all_user a, activity b, participate c, activity_pass_type d, activity_type e
WHERE 1
and a.user_student = c.user_student
and b.act_id = c.act_id
and b.act_del = 0
and b.act_pass_type = d.act_pass_type
and b.act_type = e.act_type
and a.user_student = $user_student
ORDER BY act_type ASC, act_begin_time DESC
;		
"


?>
<style type="text/css">
    .div_list{
   		width: 1750px;
   	}
</style>

    
	<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">學生查詢視窗</h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $_SERVER['PHP_SELF'];?>">
					學號查詢:<input type="text" name="student" value="<?php echo $user_student;?>"></input>
					<input type="submit" value="查詢" class="btn btn-sm btn-default">
				</form>
			</div>
		</div>
	</div>	
    <br>
		<div class="col-md-6 div_list">
			<table class="table table-condensed table_list">
				<thead>
					<tr>
						<th>學號</th>
						<th>姓名</th>
						<th>性別</th>
						<th>科系</th>
						<th>活動編號</th>
						<th>活動名稱</th>
						<th>活動開始日期</th>
						<th>核定類別</th>
						<th>時數類別</th>
						<th>核定時數</th>
						<th>基本時數</th>
						<th>高階時數</th>
					</tr>
				</thead>
<?php
		
		if($user_student != FALSE && $result_list_detail = Model::Query($mysqli, $sql_list_detail))
		{
			while($list = Model::Fetch($result_list_detail))
			{
				
echo <<<HEREDOC

            <tbody>
              <tr>
                <td>$list->user_student</td>
                <td>$list->user_name</td>
                <td>$list->user_sex</td>
                <td>$list->user_dep</td>
                <td>$list->act_id</td>
                <td><a href="list_activity.php?act_id=$list->act_id">$list->act_title</a></td>
                <td>$list->act_begin_time</td>
                <td>$list->act_pass_type_name</td>
                <td>$list->act_type_name</td>
    			<td>$list->act_service_hour</td>
    			<td>$list->basic_hour</td>	
    			<td>$list->adv_hour</td>
              </tr>
HEREDOC;

			}
		}
		ELSE
		{

echo <<<HEREDOC
			<tbody>
				<tr>
					<td>無輸入資料</td>
				</tr>
			</tbody>
HEREDOC;
		}

        ?>
                    </tbody>
          </table>
        </div>	
</body>
</html>
