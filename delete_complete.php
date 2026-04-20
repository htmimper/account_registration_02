<?php
session_start();

// DB接続（直接書く）
    $pdo = new PDO(
        'mysql:dbname=di_blog;host=localhost;charset=utf8',
        'root',
        'mysql',
);

$user_id = $_POST["user_id"];

try {
    $sql = "UPDATE users SET delete_flag = 1 WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);

    echo "<h2>削除完了しました</h2>";

} catch (Exception $e) {
    echo "<p style='color:red;'>エラーが発生したためアカウント削除できません。</p>";
}
?>

<a href="top.php">TOPへ戻る</a>