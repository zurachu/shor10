<?php

if(count($_GET) == 1)
{
	echo $_GET;
	exit;
}

$url = 'https://github.com/zurachu';
header("Location: {$url}");
exit;
?>
