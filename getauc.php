<?php
//header("Content-Type: text/xml; charset=utf-8");
header('Content-Type: application/json');
//header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('Etc/GMT-3');

function getChat($urlChat) {
    $ch2 = curl_init();
    $agent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.88 Safari/537.36 Vivaldi/1.7.735.46";
    curl_setopt($ch2, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch2, CURLOPT_URL, $urlChat);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch2, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt ($ch2, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch2, CURLOPT_COOKIEJAR, __DIR__.'/cookie.txt');
    curl_setopt($ch2, CURLOPT_COOKIEFILE, __DIR__.'/cookie.txt');
    $message = curl_exec($ch2);
    curl_close($ch2);
    return $message;
}
if (isset($_GET['title'])) {
    $title = $_GET['title'];
} else {
    $title = "";
}

$strict = false;
$titleGet = mb_strtolower($title, "UTF-8");

//urlencode не подходит т.к. тмка не понимае + вместо пробела, нужен %20
$titleGetEnc = rawurlencode($titleGet);
//echo $titleGetEnc;
//https://tmgame.ru/srv/auction/list?item_kind_grp=59&level_to=99&sort_field=1&level_from=0&ownership=3&page_size=50&page_number=1
$xmlAuc = getChat("https://tmgame.ru/srv/auction/list?page_size=50&page_number=1&title=$titleGetEnc&level_to=99&sort_field=1&level_from=0&ownership=3");
//echo $xmlAuc;
$xmlAuc = simplexml_load_string($xmlAuc);
$elem = $xmlAuc->xpath("//lot");
foreach ($elem as $el){
	$title = mb_strtolower((string)$el->items->item->title, "UTF-8");
	//echo $title."<br>";
	if ($strict){

		
		if ($title === $titleGet){
			//echo $title."<br>";
			//$el->items->item->attributes()->amount;
		}
		
	}else{
		//var_dump($el->items->item->attributes());
		$amount = (int)$el->items->item->attributes()->amount;
		if ($amount === 0) $amount=1; 
		$amount = $amount;
		$etime = (int)$el->attributes()->etime - time();
		$buyoutPrice = (int)$el->attributes()->buyout_price;
		$unitPrice = round($buyoutPrice/$amount);
		$item = ['title'=>$title, 'amount'=>$amount, 'etime'=>$etime, 'buyoutPrice'=>$buyoutPrice, 'unitPrice'=>$unitPrice];
		$lots[]=$item;
		
		//echo $unitPrice.$title.$amount."<br>";
	}
	//var_dump($el);
}
$json = json_encode( $lots, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
echo $json;
//var_dump($lots);
?>