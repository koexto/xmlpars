<?php
header ("Content-Type: text/html; charset=utf-8");
include 'config.php';
date_default_timezone_set('Etc/GMT-3');

$timeStart = -microtime(true);

libxml_use_internal_errors(true);
$clan = simplexml_load_file ('http://w0.tmgame.ru/extern/tm_info.php?action=clans');
libxml_use_internal_errors(false);
$time = $timeStart + microtime(true);
echo "loadFile = " . $time . "<br>";
//выборка uid онлайн по всем не модерским/админским кланам
$results = $clan->xpath("//clan[@id>11]");
$time = $timeStart + microtime(true);
echo "xpath = " . $time . "<br>";

//соединяемся с базой
$mysqli = new mysqli($db['host'],$db['login'],$db['pass'],$db['dbname']);
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
$mysqli->set_charset("utf8");

$selectRow = $mysqli->query("SELECT * FROM clan_all");
$prevClans = $selectRow->fetch_all();
//var_dump($prevClans);

//table clean
//$resultsDelete = $mysqli->query("TRUNCATE TABLE clan_all");
$sampleTime = date("Y-m-d H:i:s",time());
$sampleTimeIns = "'".$mysqli->real_escape_string($sampleTime)."'";
foreach ($results as $result){
    $cid = (string)$result->attributes()->id;
    $cidIns = "'".$mysqli->real_escape_string($cid)."'";
    $cName = (string)$result->attributes()->name;
    $cNameIns = "'".$mysqli->real_escape_string($cName)."'";
    $race = (string)$result->attributes()->race;
    $raceIns = "'".$mysqli->real_escape_string($race)."'";
    //var_dump($result->users->user);
    foreach ($result->users->user as $user){
        //echo $cid.$user->nick.$user->attributes()->uid.$user->attributes()->lvl."<br>";
        $uid = (string)$user->attributes()->uid;
        $uidIns = "'".$mysqli->real_escape_string($uid)."'";
        $nick = (string)$user->nick;
        $nickIns = "'".$mysqli->real_escape_string($nick)."'";
        $lvl = (string)$user->attributes()->lvl;
        $lvlIns = "'".$mysqli->real_escape_string($lvl)."'";
        $nowClans[] = [$sampleTime, $nick, $uid, $lvl, $cid];
        $insertRow = $mysqli->query("INSERT INTO clan_all (sample_time, nick, uid, lvl, cid) VALUES($sampleTimeIns, $nickIns, $uidIns, $lvlIns, $cidIns)");
    }
}
$time = $timeStart + microtime(true);
echo "insert = " . $time . "<br>";
//var_dump($nowClans);


foreach ($prevClans as $key=>$user){
    foreach($nowClans as $key2=>$userNew){
        if ($user[3]==$userNew[2]){
            if ($user[5]==$userNew[4]){
                unset($prevClans[$key]);
                unset($nowClans[$key2]);
                continue 2;
            }
            continue 2;
        }
        echo "for2".PHP_EOL;
    }
    echo "for1".PHP_EOL;
}
$time = $timeStart + microtime(true);
echo "compare = " . $time . "<br>";
var_dump($prevClans);
var_dump($nowClans);


/*$a = [[4,"koe",10,46],[5,"liska",15,45],[6,"retor89",17,45],[7,"таша",17,45]];
$b = [[4,"koe",10,45],[5,"liska",15,45],[6,"retor89",17,45],[17,"лапша",17,49]];
foreach ($a as $key=>$user){
    foreach($b as $key2=>$userNew){
        if ($user[0]==$userNew[0]){
            if ($user[3]==$userNew[3]){
                unset($a[$key]);
                unset($b[$key2]);
                continue 2;
            }
            continue 2;
        }
        echo "for2".PHP_EOL;
    }
    echo "for1".PHP_EOL;
}
var_dump($a);
var_dump($b);*/





//var_dump($results[0]->users);
    //var_dump($results);
    
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
    //echo "<h1>".count($results)."</h1>";
    
// Делаем все то же самое, чтобы получить текущее время




?>
