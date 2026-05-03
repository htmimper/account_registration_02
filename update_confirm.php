<?php
session_start();

// POSTデータ取得
$data = $_POST;

// CSRF（簡易）
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
<title>更新確認画面</title>
</head>

<body>

<h2>アカウント更新確認画面</h2>

<p>以下の内容で更新しますか？</p>

<table border="1">

<tr>
<th>名前（姓）</th>
<td><?= h($data["family_name"] ?? "") ?></td>
</tr>

<tr>
<th>名前（名）</th>
<td><?= h($data["last_name"] ?? "") ?></td>
</tr>

<tr>
<th>カナ（姓）</th>
<td><?= h($data["family_name_kana"] ?? "") ?></td>
</tr>

<tr>
<th>カナ（名）</th>
<td><?= h($data["last_name_kana"] ?? "") ?></td>
</tr>

<tr>
<th>メールアドレス</th>
<td><?= h($data["mail"] ?? "") ?></td>
</tr>

<tr>
<th>パスワード</th>
<td><?= str_repeat("●", strlen($data["password"] ?? "")) ?></td>
</tr>

<tr>
<th>性別</th>
<td><?= ($data["gender"] ?? "") == 0 ? "男" : "女" ?></td>
</tr>

<tr>
<th>郵便番号</th>
<td><?= h($data["postal_code"] ?? "") ?></td>
</tr>

<tr>
<th>住所（都道府県）</th>
<td><?= h($data["prefecture"] ?? "") ?></td>
</tr>

<tr>
<th>市区町村</th>
<td><?= h($data["address_1"] ?? "") ?></td>
</tr>

<tr>
<th>番地</th>
<td><?= h($data["address_2"] ?? "") ?></td>
</tr>

<tr>
<th>アカウント権限</th>
<td><?= ($data["authority"] ?? "") == 1 ? "管理者" : "一般" ?></td>
</tr>

</table>

<br>

<!-- 更新処理へ -->
<form action="update_complete.php" method="post">
    <?php foreach ($data as $key => $value): ?>
        <input type="hidden" name="<?= h($key) ?>" value="<?= h($value) ?>">
    <?php endforeach; ?>

    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

    <button type="submit">更新する</button>
</form>

<!-- 戻る -->
<form action="update.php" method="get">
    <input type="hidden" name="id" value="<?= h($data["id"] ?? "") ?>">
    <button type="submit">前に戻る</button>
</form>

</body>
</html>