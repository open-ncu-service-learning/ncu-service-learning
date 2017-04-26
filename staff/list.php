<?php

require_once("connect.php");
require_once("model.php");


$connect = new DBConnect();
$mysqli = $connect->connect();

$table_list = "all_user";
$sql_list = "SELECT * FROM $table_list WHERE user_status = 0 AND user_del = 0 ORDER BY user_dep_id, user_student ASC";

require_once("header.php");
?>
<style type="text/css">
    .div_list{
   		width: 1750px;
   	}
</style>

		<div class="col-md-6 div_list">
			<table class="table table-condensed table_list">
				<thead>
					<tr>
						<th>學號</th>
						<th>姓名</th>
						<th>性別</th>
						<th>身份</th>
						<th>科系</th>
						<th>服務學習-課程</th>
						<th>服務學習-校外</th>
						<th>服務學習-高階</th>
						<th>生活知能-基本</th>
						<th>生活知能-高階</th>
						<th>人文藝術-基本</th>
						<th>人文藝術-高階</th>
						<th>基本時數</th>
						<th>高階時數</th>
						<th>總共時數</th>
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
                <td>$list->user_student</td>
                <td><a href="list_detail.php?student=$list->user_student">$list->user_name</a></td>
                <td>$list->user_sex</td>
				<td>$list->user_identity</td>
    			<td>$list->user_dep</td>
    			<td>$list->type1_basic_courses</td>	
    			<td>$list->type1_basic_activity</td>	
    			<td>$list->type1_adv</td>
    			<td>$list->type2_basic</td>
    			<td>$list->type2_adv</td>
    			<td>$list->type3_basic</td>
    			<td>$list->type3_adv</td>
    			<td>$list->user_basicHour</td>
    			<td>$list->user_advanHour</td>
    			<td>$list->user_totalHour</td>
              </tr>

        
HEREDOC;

			}
		}
		
        ?>
                    </tbody>
          </table>
        </div>	
        
</body>
</html>
