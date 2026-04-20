<?php
session_start();

// DB接続（直接書く）
$pdo = new PDO(
    "mysql:host=localhost;dbname=あなたのDB名;charset=utf8",
    "root",
    ""
);

$data = $_SESSION["update_data"];

try {
    $sql = "UPDATE users SET 
        last_name=?,
        first_name=?,
        mail=?,
        password=?
        WHERE id=?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data["last_name"],
        $data["first_name"],
        $data["mail"],
        password_hash($data["password"], PASSWORD_DEFAULT),
        $data["user_id"]
    ]);

    echo "<h2>更新完了しました</h2>";

    unset($_SESSION["update_data"]);

} catch (Exception $e) {
    echo "<p style='color:red;'>エラーが発生したためアカウント更新できません。</p>";
}
?>

<a href="top.php">TOPへ戻る</a>