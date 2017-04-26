// check form
	var emptyString = /^\s*$/;
	var emailString = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
	
	function check_pass_post_archivesForm(form1) {
		if (emptyString.test(form1.name.value)) {
			alert("請輸入姓名"); 
			return false;
		}
		else if (emptyString.test(form1.dep.value)) {
			alert("請輸入系級"); 
			return false;
		}
		else if (emptyString.test(form1.act_name.value)) {
			alert("請輸入活動名稱"); 
			return false;
		}
		else if (emptyString.test(form1.act_location.value)) {
			alert("請輸入活動地點"); 
			return false;
		}
		else if (emptyString.test(form1.act_des.value)) {
			alert("請輸入活動心得"); 
			return false;
		}
		else 
			return true;
	}
	
	// 網站管理員
	function check_pass_adminForm(form1) {
		var   r   =   /^[0-9]*[1-9][0-9]*$/;
		if(form1.service_hour_1.value+form1.service_hour.value+form1.service_hour_low+form1.service_hour_high==0 || r.test(form1.service_hour_1.value)==false ||
		r.test(form1.service_hour.value)==false || r.test(form1.service_hour_low)==false ||r.test(form1.service_hour_high)==false
		){
			message+="時數須為正整數\n"; 
		}
		if (emptyString.test(form1.name.value)) {
			alert("請輸入姓名"); 
			return false;
		}
		else if (emptyString.test(form1.account.value)) {
			alert("請輸入帳號"); 
			return false;
		}
		else if (emptyString.test(form1.pass.value)) {
			alert("請輸入密碼"); 
			return false;
		}
		else if (emptyString.test(form1.repass.value)) {
			alert("請再次確認密碼"); 
			return false;
		}
		else 
			return true;
	}
	
	// 登入
	function check_pass_loginForm(form1) {
		if (emptyString.test(form1.account.value)) {
			alert("請輸入帳號"); 
			return false;
		}
		else if (emptyString.test(form1.pass.value)) {
			alert("請輸入密碼"); 
			return false;
		}
		else 
			return true;
	}
	
	// 公告
	function check_newsForm(form1) {
		var editor = FCKeditorAPI.GetInstance("description");

		if (emptyString.test(form1.title.value)) {
			alert("請輸入標題"); 
			return false;
		}
		else if (emptyString.test(editor.EditorDocument.body.innerHTML)) {
			alert("請輸入內容"); 
			return false;
		}
		else 
			return true;
	}
	
	// 活動申請(校內)
	function check_pass_apply_activitiesForm(form1) {
		var message="";
		if (emptyString.test(form1.title.value)) {
			message+="請輸入活動標題\n"; 
		}
		if (emptyString.test(form1.location.value)) {
			message+="請輸入活動地點\n"; 
		}
		if (emptyString.test(form1.begin_time.value)) {
			message+="請輸入開始活動日期\n"; 
		}
		if (emptyString.test(form1.end_time.value)) {
			message+="請輸入結束活動日期\n"; 
		}
		if (emptyString.test(form1.type.value)) {
			message+="請選擇活動類別\n"; 
		}	
		/*else if (form1.type.value != "1" && form1.type.value != "2" && form1.type.value != "3"  ) {
			alert("請選擇活動類別"); 
			return false;
		}*/
		if (emptyString.test(form1.des.value)) {
			message+="請輸入活動描述\n"; 
		}
		var   r   =  /^[0-9]*$/;
		if(
		(form1.service_hour_type.value==1 || form1.service_hour_type.value==2 || form1.service_hour_type.value==3) &&
			(r.test(form1.service_hour_1.value)==false || r.test(form1.service_hour.value)==false 
			|| r.test(form1.service_hour_low.value)==false ||r.test(form1.service_hour_high.value)==false
			|| Number(form1.service_hour_1.value)+Number(form1.service_hour.value)+Number(form1.service_hour_low.value)+Number(form1.service_hour_high.value)==0 )
		){
			message+="時數須為正整數\n"; 
		}
		if (emptyString.test(form1.service_hour_type.value)) {
			message+="請選擇認證時數類別\n"; 
		}
		if (emptyString.test(form1.person.value)) {
			message+="請輸入聯絡人\n"; 
		}
		if (emptyString.test(form1.office.value)) {
			message+="請選擇發佈單位\n"; 
		}
		if (emptyString.test(form1.email.value)) {
			message+="請輸入電子郵件\n"; 
		}
		
		if(message==""){
			return true;
		}
		else{
			alert(message);
			return false;
		}
			
	}
	
	// 活動申請(校外)
	function check_pass_apply_out_activityForm(form1) {
		if (emptyString.test(form1.title.value)) {
			alert("請輸入活動標題"); 
			return false;
		}
		else if (emptyString.test(form1.location.value)) {
			alert("請輸入活動地點"); 
			return false;
		}
		else if (emptyString.test(form1.date.value)) {
			alert("請輸入活動日期"); 
			return false;
		}
		else if (emptyString.test(form1.des.value)) {
			alert("請輸入活動描述"); 
			return false;
		}
		else 
			return true;
	}
	
	
