<?php
session_start();

// セッションが無ければ登録画面へ
if (!isset($_SESSION['form'])) {
    header('Location: regist.php');
    exit;
}

$form = $_SESSION['form'];

try {
    // DB接続
    $pdo = new PDO(
        'mysql:dbname=di_blog;host=localhost;charset=utf8',
        'root',
        'mysql',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // パスワードをハッシュ化
    $password = password_hash($form['password'], PASSWORD_DEFAULT);

    // INSERT文
    $sql = "
    INSERT INTO accounts (
        family_name,
        last_name,
        family_name_kana,
        last_name_kana,
        mail,
        password,
        gender,
        postal_code,
        prefecture,
        address_1,
        address_2,
        authority,
        delete_flag,
        registered_time,
        update_time
    ) VALUES (
        :family_name,
        :last_name,
        :family_name_kana,
        :last_name_kana,
        :mail,
        :password,
        :gender,
        :postal_code,
        :prefecture,
        :address_1,
        :address_2,
        :authority,
        0,
        NOW(),
        NOW()
    )
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':family_name' => $form['family_name'],
        ':last_name' => $form['last_name'],
        ':family_name_kana' => $form['family_name_kana'],
        ':last_name_kana' => $form['last_name_kana'],
        ':mail' => $form['mail'],
        ':password' => $password,
        ':gender' => $form['gender'],
        ':postal_code' => $form['postal_code'],
        ':prefecture' => $form['prefecture'],
        ':address_1' => $form['address_1'],
        ':address_2' => $form['address_2'],
        ':authority' => $form['authority']
    ]);

    // 入力情報だけ削除
    unset($_SESSION['form']);

} catch (PDOException $e) {
    echo '<p style="color:red;">エラーが発生したためアカウント登録できません。</p>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
 <link rel="stylesheet" href="regist_complete.css">

</head>
<body>

<header>
  ナビゲーションバー
</header>
<h1>アカウント登録完了画面</h1>
<h2>登録完了しました</h2>

<form action="index.html" method="get">
  <button type="submit">TOPページへ戻る</button>
</form>

<footer>
  フッター
</footer>

</body>
</html>
