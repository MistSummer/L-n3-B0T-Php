<?php


//Function
//set default Bangkok Timezone
date_default_timezone_set("Asia/Bangkok");

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

//check startwith string
function strncmp_startswith2($haystack, $needle) {
    return $haystack[0] === $needle[0]
        ? strncmp($haystack, $needle, strlen($needle)) === 0
        : false;
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
			//$textout="";
			$textout="";
			$textout2="";
			
			if (strpos($text, "หิว") !== false) {
				$textout = "ต่ายย่างไหม";
				$textout2 = "อร่อยน้า อิอิ";
			}
			
			else if (strncmp_startswith2($text, "เมี๊ยว") == 1 or strncmp_startswith2($text, "เหมียว") == 1 or strncmp_startswith2($text, "เมี้ยว") == 1){$textout = "ร้องเรียกเมี๊ยวๆ เดี๋ยวก็มา";}
			else if (strncmp_startswith2($text, "ขอหวย") == 1){
				//$textout =  rand(100000,999999)  ;
				$eng_date=time();
				$thaidate = thai_date($eng_date);
				$textout = "เลขนำโชคประจำ".thai_date($eng_date)." ของคุณคือ ";
				for ($i = 0; $i<6; $i++) 
				{
					$textout .= mt_rand(0,9);
				}
				
			}
			
			else if (strncmp_startswith2($text, "ขอราคา") == 1) {
				
				// สร้าง object 
				$client = new SoapClient("http://www.pttplc.com/webservice/pttinfo.asmx?WSDL", // URL ของ webservice
								array(
									   "trace"      => 1,		// enable trace to view what is happening
									   "exceptions" => 0,		// disable exceptions
									  "cache_wsdl" => 0) 		// disable any caching on the wsdl, encase you alter the wsdl server
								   );
							   


						 // ตัวแปลที่ webservice ต้องการสำหรับ GetOilPriceResult เป็นวันเดือนปีและ ภาษา  
							   $params = array(
								   'Language' => "en",
								   'DD' => date('d'),
								   'MM' => date('m'),
								   'YYYY' => date('Y')
							   );

							  // เรียกใช้ method GetOilPrice และ ใส่ตัวแปลเข้าไป 
							  $data = $client->GetOilPrice($params);
							  
							  //เก็บตัวแปลผลลัพธ์ที่ได้
							  $ob = $data->GetOilPriceResult;

				//echo($ob. "\n". "ENDDDDD1");

				//echo("ENDDDDD2". "\n");
							  
							  
							 // เนื่องจากข้อมูลที่ได้เป็น string(ในรูปแบบ xml) จึงต้องแปลงเป็น object ให้ง่ายต่อการเข้าถึง
							  $xml = new SimpleXMLElement($ob);
						   
							 // attr  PRICE_DATE , PRODUCT ,PRICE
							//loop เพื่อแสดงผล  
							// foreach ($xml  as  $key =>$val) {  
							
							  //ถ้าไม่มีราคาก็ไม่ต้องแสดงผล เนื่องจากมีบางรายการไม่มีราคา   
							foreach ($xml  as  $key =>$val) {  
							
							  // ถ้าไม่มีราคาก็ไม่ต้องแสดงผล เนื่องจากมีบางรายการไม่มีราคา   
							  if($val->PRICE != ''){
							  $textout .= $val->PRODUCT .'  '.$val->PRICE." บาท"."\n";
								}

							}
				
				
				
				
				
				
				
				
				//$textout = "เติมฟรีไหม?". "\n". "ไม่อาว" ;
				
			}
			
			
			
			$messages = [
						'type' => 'text',
						'text' => $textout
					];
			
			$messages2 = [
						'type' => 'text',
						'text' => $textout2
					];
			


			
			if ($textout2!==""){
				
				$data = [
					'replyToken' => $replyToken,
					'messages' => [$messages,$messages2],
				];
					
			}
			else{
				$data = [
					'replyToken' => $replyToken,
					'messages' => [$messages],
				];
			}
			
			
					
			
			
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			// $data = [
				// 'replyToken' => $replyToken,
				// 'messages' => [$messages],
			// ];
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
