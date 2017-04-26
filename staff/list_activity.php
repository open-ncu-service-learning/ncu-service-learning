<?php

require_once("connect.php");
require_once("model.php");
require_once("header.php");
$act_id = $_GET['act_id'];

$connect = new DBConnect();
$mysqli = $connect->connect();

$sql_activity = "
SELECT 
c.act_id,
c.act_title,
c.act_location,
c.act_begin_time,
c.act_end_time,
c.act_type,
c.act_subtype,
c.act_description,
c.act_service_hour, 
c.act_pass_type,
c.act_sticker_number,
c.act_year,
c.act_semester,
c.act_file,
c.act_link, 
c.act_req_person, 
c.act_req_office, 
c.act_req_email, 
c.act_req_phone, 
c.act_req_account, 
c.act_report, 
c.act_engage, 
c.act_questionnaire, 
c.act_test, 
c.act_other, 
c.act_time, 
c.act_ip, 
c.act_admit, 
c.act_post,
ay.act_type_name,
ab.act_subtype_name,
ap.act_pass_type_name
FROM activity c, activity_type ay , activity_subtype ab, activity_pass_type ap
WHERE 1 AND
c.act_del = 0 AND
c.act_type = ay.act_type AND
c.act_pass_type = ap.act_pass_type AND
c.act_subtype = ab.act_subtype AND
c.act_id = $act_id
";




$sql_list = 
"
SELECT 
c.act_id,
c.act_title,
c.act_location,
c.act_begin_time,
c.act_end_time,
c.act_type,
c.act_description,
c.act_service_hour, 
c.act_pass_type,
c.act_sticker_number,
c.act_year,
c.act_semester,
c.act_file,
c.act_link, 
c.act_req_person, 
c.act_req_office, 
c.act_req_email, 
c.act_req_phone, 
c.act_req_account, 
c.act_report, 
c.act_engage, 
c.act_questionnaire, 
c.act_test, 
c.act_other, 
c.act_time, 
c.act_ip, 
c.act_admit, 
c.act_post, 
-- c.act_admit_student, 
c.act_admit_time, 
c.act_post_time, 
c.act_admit_student_time, 
c.act_no, 
-- c.act_del, 
-- c.actID, 
c.act_applier, 
c.act_approver,
t.act_type_name,
s.act_pass_type_name,
a.user_student, 
p.basic_hour,
p.adv_hour,
a.user_name,
a.user_dep,
a.user_sex,
a.user_identity
FROM participate p, all_user a, activity c, activity_type t, activity_pass_type s
WHERE 1
AND p.user_student = a.user_student
AND p.act_id = c.act_id
AND c.act_type = t.act_type
AND c.act_pass_type = s.act_pass_type
AND act_del = 0
AND p.act_id = $act_id
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
				<h3 class="panel-title">活動查詢視窗</h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $_SERVER['PHP_SELF'];?>">
					輸入活動編號:<input type="text" name="act_id" value="<?php echo $act_id;?>"></input>
					<input type="submit" value="查詢" class="btn btn-sm btn-default">
				</form>
			</div>
		</div>
	</div>	
		<br>
	<?php
	if ($result_activity = Model::Query($mysqli, $sql_activity))
	{
		while($activity_rows = Model::Fetch($result_activity))
		{
echo <<<ACTIVITY
		<table class="table table-bordered" style="
		clear: float;
		width:70%;
		margin: 0 auto;
		">
			<thead>
				<tr>
					<th style="width:20%;">項目</th>
					<th>資料</th>
				</tr>
			</thead>
			<tbody>
				<tr><td>活動編號</td><td>$activity_rows->act_id</td></tr>
				<tr><td>活動申請單位</td><td>$activity_rows->act_req_office</td></tr>
				<tr><td>活動申請人</td><td>$activity_rows->act_req_person</td></tr>
				<tr><td>活動申請人帳號</td><td>$activity_rows->act_req_account</td></tr>
				<tr><td>活動申請人e-mail</td><td>$activity_rows->act_req_email</td></tr>
				<tr><td>活動申請人電話</td><td>$activity_rows->act_req_phone</td></tr>
				<tr><td>活動名稱</td><td>$activity_rows->act_title</td></tr>
				<tr><td>活動年度</td><td>$activity_rows->act_year</td></tr>
				<tr><td>活動學期</td><td>$activity_rows->act_semester</td></tr>
				<tr><td>活動地點</td><td>$activity_rows->act_location</td></tr>
				<tr><td>活動開始時間</td><td>$activity_rows->act_begin_time</td></tr>
				<tr><td>活動結束時間</td><td>$activity_rows->act_end_time</td></tr>
				<tr><td>活動類別</td><td>$activity_rows->act_type_name</td></tr>
				<tr><td>活動型態(子類別)</td><td>$activity_rows->act_subtype - $activity_rows->act_subtype_name</td></tr>
				<tr><td>認證時數</td><td>$activity_rows->act_service_hour</td></tr>
				<tr><td>認證型態</td><td>$activity_rows->act_pass_type_name</td></tr>
				<tr><td>活動內容</td><td>$activity_rows->act_description</td></tr>
			</tbody>
		</table>

ACTIVITY;
		}
	
	}
	
echo <<<HEARD
		<div class="col-md-6 div_list">
			<table class="table table-condensed table_list">
				<thead>
					<tr>
					<!--
						<th>活動編號</th>
						<th>活動標題</th>
						<th>活動地點</th>
						<th>活動敘述</th>
						<th>活動開始日期</th>
						<th>活動結束日期</th>
					-->
						<th>時數類別</th>
						<th>核定類別</th>
						<th>核定基本時數</th>
						<th>核定高階時數</th>
						<th>核可時數學生</th>
						<th>核可時數學號</th>
						<th>核可學生性別</th>
						<th>核可學生班級</th>
						<th>核可學生身份</th>
						<th>
						<th>
					</tr>
				</thead>
HEARD;
			
		
		if($result_list = Model::Query($mysqli, $sql_list))
		{	
			$num_result_rows = $result_list->num_rows;
			while($list = Model::Fetch($result_list))
			{
			

			
			
			
echo <<<HEREDOC

            <tbody>
              <tr>
			  <!--
                <td>$list->act_id</td>
                <td>$list->act_title</td>
                <td>$list->act_location</td>
                <td>$list->act_description</td>
    			<td>$list->act_begin_time</td>
    			<td>$list->act_end_time</td>
				-->
    			<td>$list->act_type_name</td>
    			<td>$list->act_pass_type_name</td>
    			<td>$list->basic_hour</td>	
				<td>$list->adv_hour</td>	
    			<td><a href="list_detail.php?student=$list->user_student">$list->user_name</a></td>
		    	<td>$list->user_student</td>
				<td>$list->user_sex</td>
				<td>$list->user_dep</td>
				<td>$list->user_identity</td>
              </tr>
HEREDOC;

			}
		}
		else
		{
echo <<<HEREDOC
			<tbody>
				<tr>
					<td>無輸入資料</td>
				<tr>
			</tbody>
HEREDOC;
		}
		
        ?>
                    </tbody>
          </table>
		  <?php

			if ($num_result_rows == 0)
				echo '<h3>無學生核可資料</h3>';
		  ?>
        </div>	
        
</body>
</html>
