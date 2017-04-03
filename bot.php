<?php

//Function

$thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
$thai_month_arr=array(
    "0"=>"",
    "1"=>"มกราคม",
    "2"=>"กุมภาพันธ์",
    "3"=>"มีนาคม",
    "4"=>"เมษายน",
    "5"=>"พฤษภาคม",
    "6"=>"มิถุนายน", 
    "7"=>"กรกฎาคม",
    "8"=>"สิงหาคม",
    "9"=>"กันยายน",
    "10"=>"ตุลาคม",
    "11"=>"พฤศจิกายน",
    "12"=>"ธันวาคม"                 
);
function thai_date($time){
    global $thai_day_arr,$thai_month_arr;
    $thai_date_return="วัน".$thai_day_arr[date("w",$time)];
    $thai_date_return.= "ที่ ".date("j",$time);
    $thai_date_return.=" เดือน".$thai_month_arr[date("n",$time)];
    $thai_date_return.= " พ.ศ.".(date("Yํ",$time)+543);
    $thai_date_return.= "  ".date("H:i",$time)." น.";
    return $thai_date_return;
}





//::: LINE SECTION :::
$access_token = 'GKKuFc6FcuRQG+7Slc8coI6X3CFubcL4fvfZTAot6lzD8ahVOeyJOF97pObyGon1Je61dHpXbFA/SXjNwJ+50ZEeDQS0dqSs5dkDY/vi6GAGUDmb5bbkFK5N0OQf22jQiyaQcMtsY7t/KSOpm6Ib7wdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			
			// Build message to reply back
						
			if (strncmp($text, "เมี๊ยว", 6) === 0 or strncmp($text, "เหมียว", 6) === 0 or strncmp($text, "เมี้ยว", 6) === 0){$textout = "ร้องเรียกเมี๊ยวๆ เดี๋ยวก็มา";}
			else if (strncmp($text, "ขอหวย", 5) === 0){
				//$textout =  rand(100000,999999)  ;
				$eng_date=time();
				$thaidate = thai_date($eng_date);
				$textout = "เลขนำโชคประจำ".thai_date($eng_date)." ของคุณคือ ";
				for ($i = 0; $i<6; $i++) 
				{
					$textout .= mt_rand(0,9);
				}
				
			}
			else if (strpos($text, 'หิว') !== false) {
				$textout = "ต่ายย่างไหม";
			}
			
			
			
			$messages = [
				{
				 'type' => 'text',
				 'text' => $textout
				 },
				{
				 'type' => 'text',
				 'text' => $textout
				 },
				 {
				 'type' => 'text',
				 'text' => $textout
				 },
				{
				 'type' => 'text',
				 'text' => $textout2
				 }
			];
			
			
			
			
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			echo $result . "\r\n";
		}
	}
}
echo "OK";
