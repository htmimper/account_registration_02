<?php
session_start();

$user_id = $_POST["user_id"] ?? null;

if (!$user_id) {
    die("IDがありません");
}
?>

<h2>本当に削除してよろしいですか？</h2>

<!-- 削除する -->
<form action="delete_complete.php" method="post">
    <input type="hidden" name="user_id" value="<?= $user_id ?>">
    <button type="submit">削除する</button>
</form>

<!-- 前に戻る（ここが重要） -->
<form action="delete.php" method="get">
    <input type="hidden" name="id" value="<?= $user_id ?>">
    <button type="submit">前に戻る</button>
</form>