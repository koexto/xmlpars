<?php
header ("Content-Type: text/html; charset=utf-8");

	$aListGnom = array();
	$aListHum = array();
	
	
    libxml_use_internal_errors(true);
    $clan = simplexml_load_file ('http://w0.tmgame.ru/extern/tm_info.php?action=clans');
    libxml_use_internal_errors(false);
    //id клана выше которого вести учет
    //1 сервер с учетом модеров: ((@id>2 and @id<5) or @id>11)
    // без модеров @id>11
    //2 сервер с модерами @id>100000001
    //без модеров @id>100000006 
    $ClansId = 11;
    $gnoms = $clan->xpath("//clan[@race=1 and ((@id>2 and @id<5) or @id>11)]/users/user/@lvl");
    $hums =  $clan->xpath("//clan[@race=2 and ((@id>2 and @id<5) or @id>11)]/users/user/@lvl");
    echo count($gnoms). "/" . count($hums) . "<br>";
    //var_dump($results);
    for($i = 0; $i < count($gnoms); $i++){
    	$lvl = (int)$gnoms[$i];
    	$aListGnom[$lvl]++;
    }
    for($i = 0; $i < count($hums); $i++){
    	$lvl = (int)$hums[$i];
    	$aListHum[$lvl]++;
    }
    for($i=0; $i<26; $i++){
    	
    	echo $i . " " . $aListGnom[$i] . " " . $aListHum[$i] . " " . $aListHum[$i]/$aListGnom[$i] . "<br>";
    }
    
    
    


?>
