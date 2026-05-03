<?php
session_start();

$pdo = new PDO(
    'mysql:host=localhost;dbname=di_blog;charset=utf8',
    'root',
    'mysql',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// POSTデータ取得
$data = $_POST;

// IDチェック
$id = $data["id"] ?? null;

if (!$id) {
    exit("IDがありません");
}

// パスワード（そのまま or 更新）
$password = $data["password"];

// UPDATE文
$sql = "
UPDATE accounts SET
family_name = ?,
last_name = ?,
family_name_kana = ?,
last_name_kana = ?,
mail = ?,
password = ?,
gender = ?,
postal_code = ?,
prefecture = ?,
address_1 = ?,
address_2 = ?,
authority = ?,
update_time = NOW()
WHERE id = ?
";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data["family_name"],
        $data["last_name"],
        $data["family_name_kana"],
        $data["last_name_kana"],
        $data["mail"],
        $password,
        $data["gender"],
        $data["postal_code"],
        $data["prefecture"],
        $data["address_1"],
        $data["address_2"],
        $data["authority"],
        $id
    ]);

} catch (Exception $e) {
    exit('<p style="color:red;">エラーが発生したためアカウント更新できません。</p>');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>更新完了</title>
</head>

<body>

<h2>更新完了しました</h2>

<form action="list.php" method="get">
    <button type="submit">TOPページへ戻る</button>
</form>

</body>
</html> 