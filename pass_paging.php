<?php
	$rowsPerPage = 20;	// 每頁幾筆
	$pageNum = 1;

	if(isset($_GET['page']))
	    $pageNum = $_GET['page'];
		
	$offset = ($pageNum - 1) * $rowsPerPage;
	$maxPage = ceil($numrows/$rowsPerPage);
	
	$self = $_SERVER['PHP_SELF'];
	$nav  = '';
	
	if($_GET['type'] != NULL)
		$newType = "type=".$_GET['type'];
	for($page = 1; $page <= $maxPage; $page++)
	{
	   if ($page == $pageNum)
	   {
	      $nav .= " <font color='#990000'><b>$page</b></font> ";
	   }
	   else
	   {
	      if($newType!='')
			$nav .= " <a href=\"$self?page=$page&$newType\">$page</a> ";
		  else
			$nav .= " <a href=\"$self?page=$page\">$page</a> ";
	   }
	}
	
	if ($pageNum > 1)
	{
	   $page  = $pageNum - 1;
	   
	   if($newType!='')
	      $prev  = " <a href=\"$self?page=$page&$newType\">[上一頁]</a> ";
	   else
	      $prev  = " <a href=\"$self?page=$page\">[上一頁]</a> ";

	   //$first = " <a href=\"$self?page=1\">[首頁]</a> ";
	}
	else
	{
	   //$prev  = '&nbsp;';
	   //$first = '&nbsp;';
	}
	
	if ($pageNum < $maxPage)
	{
	   $page = $pageNum + 1;
	   
	   if($newType!='')
	      $next = " <a href=\"$self?page=$page&$newType\">[下一頁]</a> ";
	   else
	      $next = " <a href=\"$self?page=$page\">[下一頁]</a> ";

	   //$last = " <a href=\"$self?page=$maxPage\">[頁尾]</a> ";
	}
	else
	{
	   //$next = '&nbsp;';
	   //$last = '&nbsp;';
	}
?>