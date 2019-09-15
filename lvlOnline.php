<?php
header ("Content-Type: text/html; charset=utf-8");
//парсер шмота определенных уровней по слоту шлема

$mtime = microtime();        //Считываем текущее время

$mtime = explode(" ",$mtime);    //Разделяем секунды и миллисекунды

// Составляем одно число из секунд и миллисекунд
// и записываем стартовое время в переменную
$tstart = $mtime[1] + $mtime[0];

    $dom = new domDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTMLFile ('http://tmgame.ru/extern/tm_info.php?action=clans');
    libxml_use_internal_errors(false);
    $xpath = new DOMXPath($dom);
    //выборка uid по всем не модерским/админским кланам
    $results = $xpath->query("//clan[@race=1 and @id>11]/users/user[(@lvl='12' or @lvl='10' or @lvl='11') and @online='1']/@uid");
    //несколько уровней
    //$results = $xpath->query("//clan[@race=1 and @id>11]/users/user[(@lvl='9' or @lvl='10' or @lvl='11') and @online='1']/@uid");
    var_dump($results);
    //выборка по определенным кланам
    //$results = $xpath->query("//clan[@id=20 or @id=133 or @id=15 or @id=22 or @id=18 or @id=26 or @id=25 or @id=28 or @id=35 or @id=88]/users/user[@lvl='10']/@uid");
    
    /*$rss =  simplexml_load_file('http://w0.tmgame.ru/userinfo.php?uim&nick=1972103');
    $battleAll = (int) $rss->user_info->stats->stat[3]->attributes()->value;
    $battleMon = (int) $rss->user_info->stats->stat[5]->attributes()->value;
    echo $battleAll . " - " . $battleMon . "<br>";
    
    /*foreach ($rss->xpath("//item[@slot_num='1']/title") as $item) {
				//echo $item->nodeValue . "<br>";
				echo $item;
	}*/
    if($results->length > 0) {
      for($i = 0; $i < $results->length; $i++){
        //echo $results->item($i)->nodeValue , '<br>';
        $uid = $results->item($i)->nodeValue;
        //echo $uid."<br>";
        if ($uid != 1194773 && $uid !=998130){
        	$user =  simplexml_load_file('http://w0.tmgame.ru/userinfo.php?uim&nick=' . $uid);
        	$battleAll = $user->xpath("//user_info/stats/stat[@name='Количество убийств']/@value");
        	$battleMon = $user->xpath("//user_info/stats/stat[@name='Убийств на начало месяца']/@value");
        	$region = $user->xpath("//user_info/region");
        	$region = (string) $region[0];
        	$position = $user->xpath("//user_info/position");
        	$position = (string) $position[0];
        	//$lastDate = $user->xpath("//user_info/personal_data/line[@name='Последнее посещение']/@value");
        	$battleAll = (int)$battleAll[0];
        	$battleMon = (int)$battleMon[0];
        	//$lastDate = (string)$lastDate[0];
        	$battle = $battleAll - $battleMon;
	    	//$battleAll = (int) $user->user_info->stats->stat[3]->attributes()->value;
    		//$battleMon = (int) $user->user_info->stats->stat[5]->attributes()->value;
	    	//echo $battleAll." - ".$battleMon."<br>";
	    	//var_dump($battleAll > $battleMon);
	    	//echo (int) $battleAll[0];
	    	//if ($battleMon < $battleAll){
	    		$name = $user->xpath("//user_info/name");
	    		$name = (string) $name[0];
	    		$linkPers = "<a href="."http://w0.tmgame.ru/userinfo.php?nick=".urlencode($name).">".$name."</a>";
				foreach ($user->xpath("//item[@slot_num='1']/title") as $item) {
					echo "<pre>" . $linkPers . ":	" .$item . ":	" . $battle .":	". $region .":	". $position . "</pre><br>";
				}
			//}
		}
      }
    }
    
    /*echo "<h2>Шмот</h2>";
    foreach ($shmot as $key => $value)
    	echo "<a href='http://w0.tmgame.ru/info/artinfo.php?id=".$key."'>".$value."</a><br>";
    echo "<h2>Сумки</h2>";
    foreach ($sumki as $key => $value)
    	echo "<a href='http://w0.tmgame.ru/info/artinfo.php?id=".$key."'>".$value."</a><br>";
    echo "<h2>Бижа</h2>";
    foreach ($ring as $key => $value)
    	echo "<a href='http://w0.tmgame.ru/info/artinfo.php?id=".$key."'>".$value."</a><br>";
    	*/
    //var_dump($regi);
    //var_dump($cloak);
// Делаем все то же самое, чтобы получить текущее время

$mtime = microtime();

$mtime = explode(" ",$mtime);

$mtime = $mtime[1] + $mtime[0];

$totaltime = ($mtime - $tstart);//Вычисляем разницу

// Выводим не экран

printf ("Страница сгенерирована за %f секунд !", $totaltime);


?>
