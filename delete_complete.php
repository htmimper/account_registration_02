<?php
session_start();

try {
    // DB接続
    $pdo = new PDO(
        'mysql:dbname=di_blog;host=localhost;charset=utf8',
        'root',
        'mysql',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    // POSTでID取得
    $id = $_POST["id"] ?? null;

    if (!$id) {
        die("IDがありません");
    }

    // 論理削除（delete_flag = 1）
    $sql = "UPDATE accounts SET delete_flag = 1 WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([(int)$id]);

} catch (Exception $e) {
    $error_message = "エラーが発生したためアカウント削除できません。";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>削除完了</title>
<link rel="stylesheet" href="delete_complete.css">
</head>

<body>

<header>ナビゲーションバー</header>

<h1>アカウント削除完了</h1>

<?php if (isset($error_message)) : ?>
    <p style="color:red; text-align:center;">
        <?= htmlspecialchars($error_message) ?>
    </p>
<?php else : ?>
    <p style="text-align:center;">
        削除完了しました
    </p>
<?php endif; ?>

<div class="button-area">
    <form action="index.html" method="get">
        <button type="submit">TOPページへ戻る</button>
    </form>
</div>

<footer>フッター</footer>

</body>
</html>