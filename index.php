<?php
$db_url = parse_url(getenv('DATABASE_URL'));

function is_valid_url($url)
{
    return false !== filter_var($url, FILTER_VALIDATE_URL) && preg_match('@^https?+://@i', $url);
}

if(count($_GET) == 1)
{
	$key = key($_GET);
	$value = $_GET[$key];
	try {
		$dsn = sprintf('pgsql:host=%s;dbname=%s', $db_url['host'], substr($db_url['path'], 1));
		$pdo = new PDO($dsn, $db_url['user'], $db_url['pass']);

		if($key == "source_url")
		{
			if(is_valid_url($value))
			{
				// 新規登録処理
				$statement = $pdo->prepare("INSERT IGNORE INTO url_conversion(hash, url) VALUES(:hash, :url)");
				$statement->bindParam(':hash', $hash, PDO::PARAM_STR);
				$statement->bindValue(':url', $value, PDO::PARAM_STR);
				$hash = substr(base_convert(md5(uniqid()), 16, 36), 0, 8);
				$statement->execute();
			}
			else
			{
				// 不正な URL
			}
			echo $value;
		}
		else if($value == "")
		{
			// ハッシュとみなして登録済み情報を検索
			$statement = $pdo->query("SELECT url from url_conversion where hash = '$key'");
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
