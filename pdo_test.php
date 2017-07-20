<?php
$db_url = parse_url(getenv('DATABASE_URL'));

try {
	$dsn = sprintf('pgsql:host=%s;dbname=%s', $db_url['host'], substr($db_url['path'], 1));
	$pdo = new PDO($dsn, $db_url['user'], $db_url['pass']);
	var_dump($pdo->getAttribute(PDO::ATTR_SERVER_VERSION));
} catch(PDOException $e) {
    die($e->getMessage());
}
