<?php
session_start();

$_SESSION["update_data"] = $_POST;
$data = $_POST;
?>

姓：<?= htmlspecialchars($data["last_name"]) ?><br>
名：<?= htmlspecialchars($data["first_name"]) ?><br>
メール：<?= htmlspecialchars($data["mail"]) ?><br>

<form action="update_complete.php" method="post">
    <button type="submit">更新する</button>
</form>

<form action="update.php" method="post">
    <button type="submit">前に戻る</button>
</form>