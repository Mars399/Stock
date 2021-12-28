

<?php

function get_date(){
      
     $today1 = date('d-m-Y H:i:s');
     // echo $today."\n";
  
     $today2 = date('d-m-Y H:i:s', strtotime("-60 minute"));
	 $timestamp1 = strtotime($today1);
	 $timestamp2 = strtotime($today2);
	 /*===test===
	 $date = date('d-m-Y H:i:s', $timestamp);
	 echo "Time:".$date;
	 echo "The timestamp is $timestamp1. and $timestamp2 \n";
	 ==========*/
     return array($timestamp1,$timestamp2);
}

//modify xxxxx to your stock id from yahoo

function get_Stock_price($s_date1,$s_date2){
  $url ="https://query1.finance.yahoo.com/v8/finance/chart/xxxxx?period1=".$s_date2."&period2=".$s_date1."&interval=1d&events=history&=hP2rOschxO0";
	$data = file_get_contents($url);
	$data = json_decode($data,true);
    //var_dump($data);
	$str=$data['chart']['result'][0]['meta']['symbol'];
	$high=$data['chart']['result'][0]['indicators']['quote'][0]['high'][0];
	$low=$data['chart']['result'][0]['indicators']['quote'][0]['low'][0];
	//echo $str."\n";
	//echo $high."\n";
	//echo $low."\n";
	echo $msg="Coasia Stock: ".$str."  "."High: ".$high."  "."Low: ".$low;
	return $msg;
}

function send_line_notify($msg){
//$msg=$_GET["msg"];
//echo array[0];
//echo $msg=array[0];
$line_token=xxxx;
	$headers = array('Content-Type: multipart/form-data',	'Authorization: Bearer '.$line_token );
	$message =array('message' => $msg);

	$ch = curl_init();
	curl_setopt($ch , CURLOPT_URL , "https://notify-api.line.me/api/notify");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
	$result = curl_exec($ch);
	curl_close($ch);
}	

$result = get_date();
send_line_notify(get_Stock_price($result[0],$result[1]))

?>
