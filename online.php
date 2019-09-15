<?php
header ("Content-Type: text/html; charset=utf-8");
$nicks = array("ЦарьНеба", "-%20ДУРЕМАР-", "-1буба1-");
$oline = array();
foreach ($nicks as $nick){
	$user = simplexml_load_file('http://w1.tmgame.ru/extern/tm_info.php?action=users&nick='.$nick);
	$id = $user->xpath("//user/@id");
	$id = (int)$id[0];
	$user = simplexml_load_file('http://w0.tmgame.ru/userinfo.php?uim&nick='.$id);
	$status = $user->xpath("//user_info/@status");
	$status = (int)$status[0];
}
//var_dump($user);
echo $status;
?>
