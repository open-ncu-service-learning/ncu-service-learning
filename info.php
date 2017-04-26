<?php
//echo function_exists('curl_init') ? "True" : "False"; 
/*
ini_set('display_error', true);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/");
curl_setopt($ch, CURLOPT_RETURNTRANSVER, 1);
$output = curl_exec($ch);
echo $output;
curl_close($ch);
*/
//request_streams("https://portal.ncu.edu.tw/user/abc");
//request_streams("https://ncu.edu.tw/");
echo substr("10512579",3);;
function request_streams($url, $method='GET', $params=array())
    {


        //$params = http_build_query($params, '', '&');

            $opts = array(
                'http' => array(
                    'method' => 'GET',
                    'ignore_errors' => true,
                ), 'ssl' => array(
                    'CN_match' => parse_url($url, PHP_URL_HOST),
                ),
            );
            //$url = $url . ($params ? '?' . $params : '');


			$context = stream_context_create ($opts);
        $data = file_get_contents($url, false, $context);
		echo $data;
	}
?>