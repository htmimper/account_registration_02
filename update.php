<?php
session_start();

$pdo = new PDO(
    'mysql:host=localhost;dbname=di_blog;charset=utf8',
    'root',
    'mysql',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// ID取得（GET）
$id = $_GET["id"] ?? null;

if (!$id) {
    exit("IDが指定されていません");
}

// ユーザー取得
$stmt = $pdo->prepare("SELECT * FROM accounts WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    exit("ユーザーが存在しません");
}

// エスケープ
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>アカウント更新</title>
</head>

<body>

<h2>アカウント更新画面</h2>

<form action="update_confirm.php" method="post">

<input type="hidden" name="id" value="<?= h($user["id"]) ?>">

姓：
<input type="text" name="family_name" maxlength="10"
value="<?= h($user["family_name"]) ?>"><br>

名：
<input type="text" name="last_name" maxlength="10"
value="<?= h($user["last_name"]) ?>"><br>

カナ（姓）：
<input type="text" name="family_name_kana" maxlength="10"
value="<?= h($user["family_name_kana"]) ?>"><br>

カナ（名）：
<input type="text" name="last_name_kana" maxlength="10"
value="<?= h($user["last_name_kana"]) ?>"><br>

メール：
<input type="email" name="mail" maxlength="100"
value="<?= h($user["mail"]) ?>"><br>

パスワード：
<input type="password" name="password" maxlength="10"
value="<?= h($user["password"]) ?>"><br>

性別：
<input type="radio" name="gender" value="0" <?= $user["gender"] == 0 ? "checked" : "" ?>>男
<input type="radio" name="gender" value="1" <?= $user["gender"] == 1 ? "checked" : "" ?>>女<br>

郵便番号：
<input type="text" name="postal_code" maxlength="7"
value="<?= h($user["postal_code"]) ?>"><br>

住所（都道府県）：
<input type="text" name="prefecture"
value="<?= h($user["prefecture"]) ?>"><br>

市区町村：
<input type="text" name="address_1"
value="<?= h($user["address_1"]) ?>"><br>

番地：
<input type="text" name="address_2"
value="<?= h($user["address_2"]) ?>"><br>

権限：
<select name="authority">
    <option value="0" <?= $user["authority"] == 0 ? "selected" : "" ?>>一般</option>
    <option value="1" <?= $user["authority"] == 1 ? "selected" : "" ?>>管理者</option>
</select><br>

<br>
<button type="submit">確認する</button>

</form>

</body>
</html>