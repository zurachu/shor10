<?php
$db_url = parse_url(getenv('DATABASE_URL'));

if(count($_GET) == 1)
{
	$key = key($_GET);
	$value = $_GET[$key];
	try {
		$dsn = sprintf('pgsql:host=%s;dbname=%s', $db_url['host'], substr($db_url['path'], 1));
		$pdo = new PDO($dsn, $db_url['user'], $db_url['pass']);

		if($key == "source_url")
		{
			// 新規登録処理
			echo $value;
		}
		else if($value == "")
		{
			// ハッシュとみなして登録済み情報を検索
			$statement = foreach($pdo->query("SELECT url from url_conversion where hash = '$key'");
			if($result = $statement->fetch())
			{
				header("Location: {$result['url']}");
				exit;
			}
		}
	} catch(PDOException $e) {
		print($e->getMessage());
		die($e->getMessage());
	}
	exit;
}

$url = 'https://github.com/zurachu';
header("Location: {$url}");
exit;
?>
