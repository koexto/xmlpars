<?php
header ("Content-Type: text/html; charset=utf-8");

	$aListPers = array();
    libxml_use_internal_errors(true);
    $clan = simplexml_load_file ('http://tmgame.ru/extern/tm_info.php?action=clans');
    libxml_use_internal_errors(false);
    $nick = $clan->xpath("//clan[@race=1 and @id>11]/users/user[(@lvl='9' or @lvl='10' or @lvl='11')]/nick");
    $uid = $clan->xpath("//clan[@race=1 and @id>11]/users/user[(@lvl='9' or @lvl='10' or @lvl='11')]/@uid");
    //var_dump($results);
    for($i = 0; $i < count($nick); $i++){
    	$aListPers[$i][0]=(string)$nick[$i];
    	$aListPers[$i][1]=(string)$uid[$i];
    	//echo $i. " - ". (string)$results[$i];
    
    }
    //var_dump($aListPers);
    $PersJson = json_encode( $aListPers, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
    echo $PersJson;


?>
