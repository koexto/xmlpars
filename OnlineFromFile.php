<?php
header ("Content-Type: text/html; charset=utf-8");
//парсер шмота определенных уровней по слоту шлема

$mtime = microtime();        //Считываем текущее время

$mtime = explode(" ",$mtime);    //Разделяем секунды и миллисекунды

// Составляем одно число из секунд и миллисекунд
// и записываем стартовое время в переменную
$tstart = $mtime[1] + $mtime[0];

$handle = fopen("nickpers.txt", "r");
$i = 0;
while (!feof($handle)) {
    $buffer = fgets($handle, 4096);
    $arrNick[$i]=$buffer;
    $i++;
    //echo $i;
    //echo $buffer."<br>";
}
fclose($handle);
$sumMedal = 0;
foreach($arrNick as $nick){
	$dom = new domDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTMLFile ('http://w0.tmgame.ru/extern/tm_info.php?action=users&nick='.$nick);
    libxml_use_internal_errors(false);
    $xpath = new DOMXPath($dom);
    $results = $xpath->query("//user/@id");
    $id = $results->item(0)->nodeValue;
    $user =  simplexml_load_file('http://w0.tmgame.ru/userinfo.php?uim&nick=' . $id);
    $online = $user->xpath("//user_info/@status");
    $online = (int)$online[0];
    if ($online==1){
    	echo $nick. " - online<br>";
    }else{
    	echo $nick. " - <br>";
    }
    
        //echo $results->item(0)->nodeValue."<br>";
    //var_dump($results->nodeValue);
    
//    $sumMedal = $sumMedal + $results->length;
    //echo $results->length."<br>";
}
//echo "среднее кол-во, открытых медалей: ".$sumMedal/$i;
//var_dump($arrNick);


$mtime = microtime();

$mtime = explode(" ",$mtime);

$mtime = $mtime[1] + $mtime[0];

$totaltime = ($mtime - $tstart);//Вычисляем разницу

// Выводим не экран

printf ("Страница сгенерирована за %f секунд !", $totaltime);


?>
