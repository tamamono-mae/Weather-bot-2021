<?php
	
	$token = 'TOKEN';
	$chat_id = 'CHAT_ID';
	$location = "臺南";
	$website = "http://opendata2.epa.gov.tw/AQI.json";
	
	$aid = -1;
	$url= $_SERVER['REQUEST_URI'];
	$intival = 3600;
	header("Refresh: ${intival}; URL={$url}");
	
	$getAQ = file_get_contents($website);
	$AQarray = json_decode($getAQ, TRUE);
	
	do {
		$aid = $aid + 1;
		$qLocation = $AQarray[$aid][SiteName];
	} while(strcmp($qLocation, $location) !== 0);
	
	echo $$AQarray[$aid][County] , '空氣品質指標' , '<br>';
	echo '[空氣品質] ', $AQarray[$aid][AQI] , '<br>';
	echo '[指  標  物] ', $AQarray[$aid][Pollutant] , '<br>';
	echo '[懸浮微粒] ', $AQarray[$aid][PM10] , ' μg/m3', '<br>';
	echo '[細浮微粒] ', $AQarray[$aid]["PM2.5"] , ' μg/m3', '<br>';
	echo '[臭　　氧] ', $AQarray[$aid][O3] , ' ppb', '<br>';
	echo '[狀　　態] ', $AQarray[$aid]["Status"] , '<br>';
	echo '發布時間：', $AQarray[$aid][PublishTime] , '<br>';
	$msg = $AQarray[$aid][County]; $msg .= "空氣品質指標\n";
	$msg .= "[空氣品質] "; $msg .= $AQarray[$aid][AQI]; $msg .= "\n";
	$msg .= "[指  標  物] "; $msg .= $AQarray[$aid][Pollutant]; $msg .= "\n";
	$msg .= "[懸浮微粒] "; $msg .= $AQarray[$aid][PM10]; $msg .= " μg/m3\n";
	$msg .= "[細浮微粒] "; $msg .= $AQarray[$aid]["PM2.5_AVG"]; $msg .= " μg/m3\n";
	$msg .= "[臭　　氧] "; $msg .= $AQarray[$aid][O3]; $msg .= " ppb\n";
	$msg .= "[狀　　態] "; $msg .= $AQarray[$aid]["Status"]; $msg .= "\n";
	$msg .= "發布時間： "; $msg .= $AQarray[$aid][PublishTime];
	$smsg = urlencode($msg);
	$website = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&text={$smsg}";
	$update = file_get_contents($website);
	$updatearray = json_decode($update, TRUE);
	if ((bool)$updatearray["ok"]){
	echo '<br>[  OK  ]';
	} else{
	echo '<br>[ Fail ]';
	//echo "";
	}
	
?>
