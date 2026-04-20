<?php
session_start();

// DB接続
$pdo = new PDO(
    'mysql:dbname=di_blog;host=localhost;charset=utf8',
    'root',
    'mysql',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// 戻る対応
if (isset($_SESSION["update_data"])) {
    $data = $_SESSION["update_data"];
} else {
    $user_id = $_SESSION["user_id"] ?? null;

    if (!$user_id) {
        die("ログイン情報がありません");
    }

    $sql = "SELECT * FROM users WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<form action="update_confirm.php" method="post">

姓：
<input type="text" name="last_name" maxlength="10"
value="<?= htmlspecialchars($data["last_name"] ?? '') ?>"><br>

名：
<input type="text" name="first_name" maxlength="10"
value="<?= htmlspecialchars($data["first_name"] ?? '') ?>"><br>

メール：
<input type="text" name="mail" maxlength="100"
value="<?= htmlspecialchars($data["mail"] ?? '') ?>"><br>

<!-- パスワードは空にするのが安全 -->
パスワード：
<input type="password" name="password" maxlength="10" value=""><br>

<input type="hidden" name="user_id" value="<?= htmlspecialchars($data["id"] ?? '') ?>">

<button type="submit">確認する</button>
</form>