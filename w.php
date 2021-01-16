<?php
	
	$token = 'TOKEN';
	$chat_id = 'CHAT_ID';
	$locationid = 'F-C0032-016';
	//$location_rn = "臺南市";
	$website = "https://opendata.cwb.gov.tw/opendataapi?dataid={$locationid}&authorizationkey=AUTH-KEY";
	
	$getweather = file_get_contents($website);
	$weatherxml = simplexml_load_string($getweather);
	$weatherjson = json_encode($weatherxml);
	$weatherarray = json_decode($weatherjson,TRUE);
	
	//Extract data
	//$title = $weatherarray[dataset][location][locationName]; //Bug title in the data.
	//$title = $location_rn;
	$msgsxml = $weatherarray[dataset][parameterSet][parameter];
	$msgs = array();
	foreach($msgsxml as $msg) {

		array_push($msgs, $msg[parameterValue]);	//FIFO
		//array_unshift($msgs, $msg[parameterValue]);	//LIFO
	}
	/*
	//Title Combine
	$title .= array_shift($msgs);	//FIFO
	array_unshift($msgs, $title);
	*/
	//$title .= array_pop($msgs);		//LIFO
	//array_push($msgs, $title);
	
	//Send
	//Send all
	/*
	foreach($msgs as $msg) {
		$smsg = urlencode($msg);
		$website = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&text={$smsg}";
		$update = file_get_contents($website);
		$updatearray = json_decode($update, TRUE);
		echo $msg, "<br>";
		if ((bool)$updatearray["ok"]){
			echo '[  OK  ]<br><br>';
		} else{
			echo '[ Fail ]<br><br>';
		}
		
	}
	*/
	//Send only one
	$smsg = urlencode($msgs[2]);
	$website = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&text={$smsg}";
	$update = file_get_contents($website);
	$updatearray = json_decode($update, TRUE);
	echo $msgs[2], "<br>";
	if ((bool)$updatearray["ok"]){
		echo '[  OK  ]<br><br>';
	} else{
		echo '[ Fail ]<br><br>';
	}
	
?>
