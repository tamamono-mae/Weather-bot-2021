<?php
	
	$token = 'TOKEN';
	$chat_id = 'CHAT_ID';
	$location = "臺南";
	$website = "https://opendata.epa.gov.tw/ws/Data/ATM00698/?$filter=SiteName%20eq%20%27%E8%87%BA%E5%8D%97%27%20and%20Weather%20ne%20%27%27&$select=SiteName,WindDirection,WindPower,Temperature,Moisture,AtmosphericPressure,Weather,Rainfall1day,Unit,DataCreationDate&$skip=0&$top=1&format=json";
	
	$aid = -1;
	$url= $_SERVER['REQUEST_URI'];
	$intival = 7200;
	header("Refresh: ${intival}; URL={$url}");
	
	$getweather = file_get_contents($website);
	$weatherarray = json_decode($getweather, TRUE);
	
	do {
		$aid = $aid + 1;
		$qLocation = $weatherarray[$aid][SiteName];
		$qWeather = $weatherarray[$aid][Weather];
	} while((strcmp($qLocation, $location) !== 0) || (strcmp($qWeather, NULL) == 0));
	
	echo $weatherarray[$aid][SiteName] , '即時氣象', '<br>';
	echo '[溫　　度] ', $weatherarray[$aid][Temperature] , ' °C', '<br>';
	echo '[天　　氣] ', $weatherarray[$aid][Weather], '<br>';
	echo '[相對濕度] ', $weatherarray[$aid][Moisture] , ' %', '<br>';
	echo '[能  見  度] ', $weatherarray[$aid][Visibility] , ' KM', '<br>';
	echo '[風　　向] ', $weatherarray[$aid][WindDirection], '<br>';
	echo '[風 力 (級)] ', $weatherarray[$aid][WindPower], '<br>';	
	echo '發布時間：', $weatherarray[$aid][DataCreationDate], '<br>';
	$msg = $weatherarray[$aid][SiteName]; $msg .= "即時氣象 \n";
	$msg .= "[溫　　度] "; $msg .= $weatherarray[$aid][Temperature]; $msg .= " °C\n";
	$msg .= "[天　　氣] "; $msg .= $weatherarray[$aid][Weather]; $msg .= "\n";
	$msg .= "[相對濕度] "; $msg .= $weatherarray[$aid][Moisture]; $msg .= " %\n";
	$msg .= "[能  見  度] "; $msg .= $weatherarray[$aid][Visibility]; $msg .= " KM\n";
	$msg .= "[風　　向] "; $msg .= $weatherarray[$aid][WindDirection]; $msg .= "\n";
	$msg .= "[風力 (級)] "; $msg .= $weatherarray[$aid][WindPower]; $msg .= "\n";
	$msg .= "發布時間： "; $msg .= $weatherarray[$aid][DataCreationDate];
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
