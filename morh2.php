<?php
header ("Content-Type: text/html; charset=utf-8");
//морриган
//$uId = "100027994";
$uId = "100246835";
$user = simplexml_load_file('http://w1.tmgame.ru/userinfo.php?uim&nick='.$uId);
$aStatus = $user->xpath("//user_info/@status");
$status = (int)$aStatus[0];
//var_dump($user);
echo $status;
?>
