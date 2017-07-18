<?php

if(count($_GET) == 1)
{
	var_dump($_GET);
	exit;
}

$url = 'https://github.com/zurachu';
header("Location: {$url}");
exit;
?>
