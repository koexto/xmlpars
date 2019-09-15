<?php
header ("Content-Type: text/html; charset=utf-8");
//парсер шмота определенных уровней по слоту шлема

$mtime = microtime();        //Считываем текущее время

$mtime = explode(" ",$mtime);    //Разделяем секунды и миллисекунды

// Составляем одно число из секунд и миллисекунд
// и записываем стартовое время в переменную
$tstart = $mtime[1] + $mtime[0];

    libxml_use_internal_errors(true);
    $clan = simplexml_load_file ('http://w0.tmgame.ru/extern/tm_info.php?action=clans');
    libxml_use_internal_errors(false);
    //выборка uid онлайн по всем не модерским/админским кланам
    $results = $clan->xpath("//clan[@id>11]/users/user[@online='1']/@uid");
    //определенный уровень
    //$results = $clan->xpath("//clan[@race=1 and @id>11]/users/user[@lvl='12' and @online='1']/nick");
    //несколько уровней
    //$results = $clan->xpath("//clan[@race=1 and @id>11]/users/user[(@lvl='9' or @lvl='10' or @lvl='11') and @online='1']/@uid");
    
    
    //вывод списка персов онлайн
    /*for($i = 0; $i < count($results); $i++){
		$Nick=(string) $results[$i];
		//просто вывод кликабельных ссылок на онлайн персов
		echo "<a href="."http://w1.tmgame.ru/userinfo.php?nick=".urlencode($Nick).">".$Nick."</a></br>";
		
  	}*/
    
    
    /*$rss =  simplexml_load_file('http://w0.tmgame.ru/userinfo.php?uim&nick=1972103');
    $battleAll = (int) $rss->user_info->stats->stat[3]->attributes()->value;
    $battleMon = (int) $rss->user_info->stats->stat[5]->attributes()->value;
    echo $battleAll . " - " . $battleMon . "<br>";
    
    /*foreach ($rss->xpath("//item[@slot_num='1']/title") as $item) {
				//echo $item->nodeValue . "<br>";
				echo $item;
	}*/
    echo "<h1>".count($results)."</h1>";
    
// Делаем все то же самое, чтобы получить текущее время

$mtime = microtime();

$mtime = explode(" ",$mtime);

$mtime = $mtime[1] + $mtime[0];

$totaltime = ($mtime - $tstart);//Вычисляем разницу

// Выводим не экран

printf ("Страница сгенерирована за %f секунд !", $totaltime);


?>
