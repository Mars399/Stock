
<?php
function get_Stock_price($s_id){
	$url ="https://mis.twse.com.tw/stock/api/getStockInfo.jsp?ex_ch=otc_".$s_id.".tw&json=1&delay=0";
	$data = file_get_contents($url);
	$data = json_decode($data,true);
//	$sell_pirce=array();
	$str=$data['msgArray'][0]['a'];
	$str_sec=explode("_",$str);
//    echo max($str_sec);
//	echo $str_sec[0];//." ".$str_sec[1]." ".$str_sec[2]." ".$str_sec[3]." ".$str_sec[4];
//    $sell_pirce=array[0];
	//	echo "High:".$data['msgArray'][0]['h'];
	$msg="Stock: ".$data['msgArray'][0]['n']."  "."High: ".max($str_sec)."  "."Low: ".$data['msgArray'][0]['l'];
//	echo "Stock ID:".$data['msgArray'][0]['c']." "."High:".$data['msgArray'][0]['h']." "."Low:".$data['msgArray'][0]['l']."\n";
	return $msg;
}

//send line notify
function send_line_notify($msg){
//$msg=$_GET["msg"];
//echo array[0];
//echo $msg=array[0];
//xxxx is line token;
	$headers = array(
    	'Content-Type: multipart/form-data',
    	'Authorization: Bearer xxxxx'
	);
//$message = array('message' => 'Good job!~');

	$message =array('message' => $msg);

	$ch = curl_init();
	curl_setopt($ch , CURLOPT_URL , "https://notify-api.line.me/api/notify");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
	$result = curl_exec($ch);
	curl_close($ch);
}	
//zzzz is stock id of taiwan
send_line_notify(get_Stock_price(zzzz))



?>
