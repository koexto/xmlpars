<?php
header ("Content-Type: text/html; charset=utf-8");
//парсер шмота определенных уровней по слоту шлема

$mtime = microtime();        //Считываем текущее время

$mtime = explode(" ",$mtime);    //Разделяем секунды и миллисекунды

// Составляем одно число из секунд и миллисекунд
// и записываем стартовое время в переменную
$tstart = $mtime[1] + $mtime[0];

//номера локаций
//колизей 375, лока у колиза 48?
$aSolik = array(14,117,116,115,114,19,18,16,17,36,37,20,21,22,23,35,24,52,25,26,27,29,28,55,54,53,59,58,57,56,30,38,39,130,84,83,82,60,87,86,85,129,128,93,92,91,90,94,95,96,97,127,435,445,6000,6001,6003,446,447);
$aCaty = range(132,182);
$aUley = array(6258, 6259, 6260, 6261, 6262, 6269, 6270, 6272, 6273, 6280, 6281, 6282, 6283, 6284);
$aPodz = array(585, 582, 3307, 586, 3308, 587, 584, 579, 588, 589, 590, 591, 580, 595);
$aKoliz = array(375);
$aAllSoliDor = array_merge($aSolik, $aCaty, $aUley, $aPodz);

//$aPers = array("Солдат_Удачи", PumbaDimon, wacy)
    //$dom = new domDocument();
    libxml_use_internal_errors(true);
    $clan = simplexml_load_file ('http://w0.tmgame.ru/extern/tm_info.php?action=clans');
    libxml_use_internal_errors(false);
    //$xpath = new DOMXPath($dom);
    //выборка uid по всем не модерским/админским кланам
    //$results = $clan->xpath("//clan[@race=1 and @id>0]/users/user[@lvl='14' and @online='1']/nick");
    //$results = $clan->xpath("//clan[@race=1 and @id>0]/users/user[@lvl='14' and @online='1']/@uid");
    //несколько уровней
    $results = $clan->xpath("//clan[@race=1 and @id>11]/users/user[(@lvl='10' or @lvl='11' or @lvl='12' or @lvl='13') and @online='1']/nick");
    //var_dump($results);
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
	$aNick = array();
	
	if(count($results) > 0) {
      for($i = 0; $i < count($results); $i++){
		$aNick[$i]=(string) $results[$i];
		//просто вывод кликабельных ссылок на онлайн персов
		//echo "<a href="."http://w1.tmgame.ru/userinfo.php?nick=".urlencode($aNick[$i]).">".$aNick[$i]."</a></br>";
		
  		}
  	}
  	//дополнительные ники
  	$aNickMy = array("шпана", "-механник-", "Любитель","Друг-1","Lekterus","СамыйСтарыйГном","ВсеМ Писец","GnoMiWKA","waky","оригон","BoJlbTpoH");
  	$aNick = array_merge($aNick, $aNickMy);
  	
  	$sSolik = "<h3>Соли-Дор</h3>";
  	$sCaty = "<h3>Каты</h3>";
  	$sPodz = "<h3>Подземка</h3>";
  	$sUley = "<h3>Улей</h3>";
  	$sKoliz = "<h3>Колиз</h3>";
    if(count($aNick) > 0) {
    
    	
      for($i = 0; $i < count($results); $i++){
      	  $nick = $aNick[$i];
      	  $user = simplexml_load_file('http://w0.tmgame.ru/extern/tm_info.php?action=users&nick='.$nick);
      	  $aLocId = $user->xpath("//user/@loc_id");
      	  $locId = (int)$aLocId[0];
      	  //echo $nick." - ". $locId."<br>";
      	  
      	  
      	  //если нужно вывести персонажей только в соли-доре
      	  
      	  if(in_array($locId, $aSolik)){
      	  	  $sSolik .= "<a href="."http://w0.tmgame.ru/userinfo.php?nick=".urlencode($nick).">".$nick."</a>" . " : ". $locId."<br>";
      	  	 //echo "<a href="."http://w0.tmgame.ru/userinfo.php?nick=".urlencode($nick).">".$nick."</a>" . " : ". $locId."<br>";
      	  }
      	  if(in_array($locId, $aCaty)){
      	  	  $sCaty .= "<a href="."http://w0.tmgame.ru/userinfo.php?nick=".urlencode($nick).">".$nick."</a>" . " : ". $locId."<br>";
      	  }
      	  if(in_array($locId, $aPodz)){
      	  	  $sPodz .= "<a href="."http://w0.tmgame.ru/userinfo.php?nick=".urlencode($nick).">".$nick."</a>" . " : ". $locId."<br>";
      	  }
      	  if(in_array($locId, $aUley)){
      	  	  $sUley .= "<a href="."http://w0.tmgame.ru/userinfo.php?nick=".urlencode($nick).">".$nick."</a>" . " : ". $locId."<br>";
      	  }
      	  if(in_array($locId, $aKoliz)){
      	  	  $sKoliz .= "<a href="."http://w0.tmgame.ru/userinfo.php?nick=".urlencode($nick).">".$nick."</a>" . " : ". $locId."<br>";
      	  }
      	  
      	  
        //echo $results->item($i)->nodeValue , '<br>';
        //$nick = $results->item($i)->nodeValue;
        //var_dump($results[$i]->nodeValue);
        //echo (string) $results[$i];
        //echo $nick."<br>";
        
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
	
	echo $sSolik;
	echo $sCaty;
	echo $sPodz;
	echo $sUley;
	
	
$mtime = microtime();

$mtime = explode(" ",$mtime);

$mtime = $mtime[1] + $mtime[0];

$totaltime = ($mtime - $tstart);//Вычисляем разницу

// Выводим не экран

printf ("Страница сгенерирована за %f секунд !", $totaltime);


?>
