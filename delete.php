<?php
session_start();

// DB接続（直書き）
$pdo = new PDO(
    'mysql:dbname=di_blog;host=localhost;charset=utf8',
    'root',
    'mysql',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// 一覧画面から渡されたIDを取得
$user_id = $_GET["id"] ?? null;

if (!$user_id) {
    die("IDが指定されていません");
}

// アカウント情報取得（accountsテーブルに統一）
$sql = "SELECT * FROM accounts WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("対象のアカウントが存在しません");
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>アカウント削除</title>
</head>

<body>

<h2>アカウント削除画面</h2>

<table border="1">

<tr><td>名前（姓）</td><td><?= htmlspecialchars($user["family_name"]) ?></td></tr>
<tr><td>名前（名）</td><td><?= htmlspecialchars($user["last_name"]) ?></td></tr>

<tr><td>カナ（姓）</td><td><?= htmlspecialchars($user["family_name_kana"]) ?></td></tr>
<tr><td>カナ（名）</td><td><?= htmlspecialchars($user["last_name_kana"]) ?></td></tr>

<tr><td>メールアドレス</td><td><?= htmlspecialchars($user["mail"]) ?></td></tr>

<tr><td>パスワード</td><td>●●●●●●</td></tr>

<tr>
<td>性別</td>
<td><?= $user["gender"] == 0 ? "男" : "女" ?></td>
</tr>

<tr><td>郵便番号</td><td><?= htmlspecialchars($user["postal_code"]) ?></td></tr>

<tr><td>住所（都道府県）</td><td><?= htmlspecialchars($user["prefecture"]) ?></td></tr>
<tr><td>住所（市区町村）</td><td><?= htmlspecialchars($user["address_1"]) ?></td></tr>
<tr><td>住所（番地）</td><td><?= htmlspecialchars($user["address_2"]) ?></td></tr>

<tr>
<td>アカウント権限</td>
<td><?= $user["authority"] == 0 ? "一般" : "管理者" ?></td>
</tr>

</table>

<br>

<!-- 削除確認へ -->
<form action="delete_confirm.php" method="post">
    <input type="hidden" name="user_id" value="<?= $user["id"] ?>">
    <button type="submit">確認する</button>
</form>

</body>
</html> 