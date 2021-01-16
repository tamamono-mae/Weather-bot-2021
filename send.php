<?php
if (isset($_POST['chat_id']) && isset($_POST['text'])) {
    //echo '<br />The ' . $_POST['chat_id'] . ' submit button was pressed<br />';
    	$token = 'TOKEN';
	$chat_id = $_POST['chat_id'];
	$content = urlencode($_POST['text']);
	$website = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&text={$content}";
	$update = file_get_contents($website);
	$updatearray = json_decode($update, TRUE);
	if ((bool)$updatearray["ok"]){
		echo 'send ', $content , ' ........... [  OK  ]<br><br>';
	} else{
		echo 'send ', $content , ' ........... [ Fail ]<br><br>';
	}
}
echo '<br><input type="button" value="Rewrite" onclick="', "location='", "write.php" , "'",'"/>';

?>