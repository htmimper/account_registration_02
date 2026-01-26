<?php
session_start();

// セッションにデータが無い場合は登録画面へ戻す
if (!isset($_SESSION['form'])) {
    header('Location: regist.php');
    exit;
}

$form = $_SESSION['form'];

// 性別・権限の表示用変換
$gender = ($form['gender'] == 0) ? '男' : '女';
$authority = ($form['authority'] == 0) ? '一般' : '管理者';

// パスワード表示用（●）
$password_mask = str_repeat('●', strlen($form['password']));
?>
<!doctype html>
<head>
  <meta charset="utf-8">
  <title>アカウント登録確認画面</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>  
<table>
<tr>
  <th>名前（姓）</th>
  <td><?= htmlspecialchars($form['family_name']) ?></td>
</tr>
<tr>
  <th>名前（名）</th>
  <td><?= htmlspecialchars($form['last_name']) ?></td>
</tr>
<tr>
  <th>カナ（姓）</th>
  <td><?= htmlspecialchars($form['family_name_kana']) ?></td>
</tr>
<tr>
  <th>カナ（名）</th>
  <td><?= htmlspecialchars($form['last_name_kana']) ?></td>
</tr>
<tr>
  <th>メールアドレス</th>
  <td><?= htmlspecialchars($form['mail']) ?></td>
</tr>
<tr>
  <th>パスワード</th>
  <td><?= $password_mask ?></td>
</tr>
<tr>
  <th>性別</th>
  <td><?= $gender ?></td>
</tr>
<tr>
  <th>郵便番号</th>
  <td><?= htmlspecialchars($form['postal_code']) ?></td>
</tr>
<tr>
  <th>住所（都道府県）</th>
  <td><?= htmlspecialchars($form['prefecture']) ?></td>
</tr>
<tr>
  <th>住所（市区町村）</th>
  <td><?= htmlspecialchars($form['address_1']) ?></td>
</tr>
<tr>
  <th>住所（番地）</th>
  <td><?= htmlspecialchars($form['address_2']) ?></td>
</tr>
<tr>
  <th>アカウント権限</th>
  <td><?= $authority ?></td>
</tr>
</table>

<br>
<!-- 前に戻る -->
<form method="post" action="regist.php" style="display:inline;">
  <button type="submit">前に戻る</button>
</form>
    
<!-- 登録する -->
<form method="post" action="regist_complete.php" style="display:inline;">
  <button type="submit">登録する</button>
</form>
    <footer>
        フッター
    </footer>
</body>
</html>
