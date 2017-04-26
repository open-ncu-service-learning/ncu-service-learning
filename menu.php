
<!-- Menu -->
		<script type="text/javascript">
			var myMenu =
			[
				[null,	' | 首頁',		'index.php',		'_self',		'首頁'],
				[null,	' | 簡介',		'index.php',		'_self',		'簡介',
					[null,	'服務學習辦公室簡介',			'intro.php',		'_self',	'服務學習辦公室簡介'],
					[null,	'組織成員',			'office.php',		'_self',	'組織成員'],
					[null,	'服務學習Logo意涵',			'serv_logo.php',		'_self',	'服務學習Logo意涵'],
					[null,	'服務學習辦公室位置',			'serv_position.php',		'_self',	'服務學習辦公室位置'],
					
				],
				[null,	' | 相關辦法',		'index.php',		'_self',		'簡介',
					[null,	'服務學習施行辦法',			'pass_rule1.php',	'_self',	'服務學習施行辦法'],
					[null,	'服務學習實施細則',		'pass_rule2.php',	'_self',	'服務學習實施細則'],					
					[null,	'三大學習領域認證時數分配表(104學年度入學適用)',		'download/pass_files_new/three.pdf',	'_self',	'三大學習領域認證時數分配表'],
					[null,	'三大學習領域認證時數分配表(105學年度入學適用)',		'download/pass_files_new/three_105.pdf',	'_self',	'三大學習領域認證時數分配表'],
					[null,	'三大學習領域認證時數分配表(106學年度入學適用)',		'download/pass_files_new/three_106.pdf',	'_self',	'三大學習領域認證時數分配表'],
					[null,	'認證時數細目表',		'download/pass_files_new/itemTable.pdf',	'_self',	'認證時數細目表'],
					[null,	'畢業審查作業要點',		'download/pass_files_new/100hours_point.pdf',	'_self',	'畢業審查作業要點'],
					[null,	'學生學習護照實施流程',		'download/pass_files_new/process.pdf',	'_self',	'實施流程'],
					[null,	'國際服務學習獎學金辦法',		'download/pass_files_new/internal.pdf',	'_self',	'國際服務學習獎學金辦法'],	
					[null,	'服務學習績優獎學金實施辦法',		'download/pass_files_new/ziyo.pdf',	'_self',	'服務學習績優獎學金實施辦法'],	
					[null,	'服務學習學生自主團隊補助計畫',		'download/pass_files_new/TEAM.pdf',	'_self',	'中央大學服務學習學生自主團隊補助計畫'],										
				],	
				[null,	' | 最新消息',		'pass_new_news.php',		'_self',	'最新訊息',
					[null,	'校內公告',		'pass_new_news_type.php?type=1',	'_self',	'校內公告'],
					[null,	'校外公告',		'pass_new_news_type.php?type=2',	'_self',	'校外公告'],				
				],
				
								
				[null,	' | 最新認證活動',	'pass_new_activity.php',	'_self',	'最新活動'],
				[null,	' | 海外志工',		'oversea.php',		'_self',		'海外志工'],
				[null,	' | 表單下載',		'post_attach.php',		'_self',		'下載專區'],
				/*[null,	' | 互動分享區',	'interactive.php',		'_self',		'互動分享區',
					
					[null,	'護照天使',		'angel-1.php',				'_new',		'護照天使'],
					
					[null,	'社團服務',		'presentation_98_w.php',				'_self',		'社團服務'],
					[null,	'活動成果',		'out_service.php',				'_self',		'活動成果'],
					[null,	'個人認證學習成果',		'pass_archives.php',	'_self',	'個人認證學習成果'],
					[null,	'服務學習LOGO競賽',		'award.php',	'_self',	'個人認證學習成果'],
				],*/	
				[null,	' | 服務學習期刊',	'periodical.php',		'_self',		'服務學習期刊'
					/*,					
					[null,	'創刊號',		'./periodical/創刊號.pdf',				'_new',		'創刊號'],
					[null,	'第二刊',		'./periodical/第二刊.pdf',				'_new',		'第二刊'],
					[null,	'第三刊',		'./periodical/第三刊.pdf',				'_new',		'第三刊'],
					[null,	'第四刊',		'./periodical/第四刊.pdf',				'_new',		'第四刊'],
					[null,	'第五刊',		'./periodical/第五刊.pdf',				'_new',		'第五刊'],
					[null,	'第六刊',		'./periodical/第六刊.pdf',				'_new',		'第六刊'],
					[null,	'第七刊',		'./periodical/第七刊.pdf',				'_new',		'第七刊'],*/
				],
				[null,	' | Q&A',		'index.php',		'_self',		'Q&A',
					[null,	'Q&A',		'download/pass_files/Q&A.pdf',	'_self',	'Q&A'],
					[null,	'服務學習課程選課說明',		'download/pass_files/選課說明_for教務處選課系統_服務學習改.rtf',	'_self',	'服務學習課程選課說明'],
					
			]	];
		</script>
		<div id="myMenuID"></div>
		<script type="text/javascript">
			var prop = cmClone(cmThemeMiniBlack);
			prop.effect = new CMSlidingEffect(5);
			cmDraw ('myMenuID', myMenu, 'hbr', prop);
		</script>
