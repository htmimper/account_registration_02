<?php
session_start();

$pdo = new PDO(
    'mysql:host=localhost;dbname=di_blog;charset=utf8',
    'root',
    'mysql',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// ID取得
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === false || $id === null) {
    exit('不正なIDです');
}

// ユーザー取得
$stmt = $pdo->prepare("SELECT * FROM accounts WHERE id = ?");
$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    exit('ユーザーが存在しません');
}

// エスケープ
function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

// CSRF対策
$_SESSION['token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
<title>アカウント更新</title>

<link rel="stylesheet" href="regist.css">

</head>

<body>

<header>
    ナビゲーションバー
</header>

<h1>アカウント更新</h1>

<div class="form-area">

<form action="update_confirm.php" method="post">

<input type="hidden" name="id" value="<?= h($user['id']) ?>">

<input type="hidden"
       name="token"
       value="<?= h($_SESSION['token']) ?>">

<!-- 名前（姓） -->
名前（姓）<br>

<div class="form-row">
    <input type="text"
           name="family_name"
           maxlength="10"
           value="<?= h($user['family_name']) ?>">
</div>

<!-- 名前（名） -->
名前（名）<br>

<div class="form-row">
    <input type="text"
           name="last_name"
           maxlength="10"
           value="<?= h($user['last_name']) ?>">
</div>

<!-- カナ（姓） -->
カナ（姓）<br>

<div class="form-row">
    <input type="text"
           name="family_name_kana"
           maxlength="10"
           value="<?= h($user['family_name_kana']) ?>">
</div>

<!-- カナ（名） -->
カナ（名）<br>

<div class="form-row">
    <input type="text"
           name="last_name_kana"
           maxlength="10"
           value="<?= h($user['last_name_kana']) ?>">
</div>

<!-- メール -->
メールアドレス<br>

<div class="form-row">
    <input type="email"
           name="mail"
           maxlength="100"
           value="<?= h($user['mail']) ?>">
</div>

<!-- パスワード -->
パスワード<br>

<div class="form-row">
    <input type="password"
           name="password"
           maxlength="255"
           >
</div>

<!-- 性別 -->
<div class="form-row">
    <label>性別</label>

    <div class="gender-group">
        <label>
            <input type="radio" name="gender" value="0"
                <?= $user['gender'] == 0 ? 'checked' : '' ?>>
            男
        </label>

        <label>
            <input type="radio" name="gender" value="1"
                <?= $user['gender'] == 1 ? 'checked' : '' ?>>
            女
        </label>
    </div>
</div>

<!-- 郵便番号 -->
郵便番号<br>

<div class="form-row">
    <input type="text"
           name="postal_code"
           maxlength="7"
           value="<?= h($user['postal_code']) ?>">
</div>

<!-- 都道府県 -->
住所（都道府県）<br>

<div class="form-row">
    <input type="text"
           name="prefecture"
           value="<?= h($user['prefecture']) ?>">
</div>

<!-- 市区町村 -->
住所（市区町村）<br>

<div class="form-row">
    <input type="text"
           name="address_1"
           value="<?= h($user['address_1']) ?>">
</div>

<!-- 番地 -->
住所（番地）<br>

<div class="form-row">
    <input type="text"
           name="address_2"
           value="<?= h($user['address_2']) ?>">
</div>

<!-- 権限 -->
アカウント権限<br>

<div class="form-row">

<select name="authority">

    <option value="0"
        <?= $user['authority'] == 0 ? 'selected' : '' ?>>
        一般
    </option>

    <option value="1"
        <?= $user['authority'] == 1 ? 'selected' : '' ?>>
        管理者
    </option>

</select>

</div>

<br><br>

<button type="submit">
    確認する
</button>

</form>

</div>

<footer>
    フッター
</footer>

</body>
</html>