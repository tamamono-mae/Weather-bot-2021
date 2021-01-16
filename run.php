<?php

	session_start();
	$url1= $_SERVER['REQUEST_URI'];
	$intival = rand ($_SESSION['intival_min'] , $_SESSION['intival_max']);
	header("Refresh: ${intival}; URL=$url1");
	//header("Refresh: 1; URL={$url1}");
	$i = 0;
	/*
	$adb = array(
		1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25
	);
	echo $_SESSION['token'];
	echo "<br>";
	echo $_SESSION['chat_id'];
	echo "<br>";
	*/
	//Pop a key and send it.
	$msg_key = array_shift($_SESSION['rand_keys']);
	$website = "https://api.telegram.org/bot{$_SESSION['token']}/sendMessage?chat_id={$_SESSION['chat_id']}&text={$_SESSION['adb'][$msg_key]}";
	$update = file_get_contents($website);
	$updatearray = json_decode($update, TRUE);
	if ((bool)$updatearray["ok"]){
	echo 'send ', $_SESSION['adb'][$msg_key] , ' ........... [  OK  ]<br><br>';
	} else{
	echo 'send ', $_SESSION['adb'][$msg_key] , ' ........... [ Fail ]<br><br>';
	//echo "";
	}
	echo 'next value: ' , $_SESSION['adb'][$_SESSION['rand_keys'][0]], '<br><br>';
	
	//Push and check a new random key.
	//Make new random array
	$pre_rand = range(0, $_SESSION['total_size'] - 1);
	shuffle($pre_rand);
	do {
	//$rand_int = random_int ( 0 , 24 );	//Avaiable in PHP 7
	$int_drop = false;
	//Get random value
	$rand_int = array_shift($pre_rand);
		for ($i = 0; $i < ($_SESSION['total_size'] - $_SESSION['repeat_range']); $i++) {
		$int_drop = $int_drop || ($rand_int == $_SESSION['rand_keys'][$i]);
		}
	} while ($int_drop);
	//var_dump($_SESSION['rand_keys']);
	array_push($_SESSION['rand_keys'], $rand_int);
	echo 'got value: ', $_SESSION['adb'][$rand_int] , '<br><br>';
	echo 'Please wait ', $intival , ' seconds.<br><br>';
	//echo '<a href="', $_SESSION['run_path'], '">Send</a>　　';
	//echo '<a href="', $_SESSION['stop_path'], '">Stop</a>';
	echo '<input type="button" value="Send" onclick="', "location='",$_SESSION['run_path'], "'",'"/>　　';
	echo '<input type="button" value="Stop" onclick="', "location='",$_SESSION['stop_path'], "'",'"/>';
?>