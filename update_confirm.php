<?php
session_start();

// POSTデータ取得
$data = $_POST;

// CSRF
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

<link rel="stylesheet" href="update_confirm.css">

</head>

<body>

<div class="wrapper">

    <h1 class="page-title">
        アカウント更新確認画面
    </h1>

    <div class="container">

        <div class="nav">
            ナビゲーションバー
        </div>

        <div class="content">

            <h2 class="section-title">
                アカウント更新確認画面
            </h2>

            <div class="row">
                <div class="label">名前（姓）</div>
                <div class="value">
                    <?= h($data["family_name"] ?? "") ?>
                </div>
            </div>

            <div class="row">
                <div class="label">名前（名）</div>
                <div class="value">
                    <?= h($data["last_name"] ?? "") ?>
                </div>
            </div>

            <div class="row">
                <div class="label">カナ（姓）</div>
                <div class="value">
                    <?= h($data["family_name_kana"] ?? "") ?>
                </div>
            </div>

            <div class="row">
                <div class="label">カナ（名）</div>
                <div class="value">
                    <?= h($data["last_name_kana"] ?? "") ?>
                </div>
            </div>

            <div class="row">
                <div class="label">メールアドレス</div>
                <div class="value">
                    <?= h($data["mail"] ?? "") ?>
                </div>
            </div>

            <div class="row">
                <div class="label">パスワード</div>
                <div class="value">
                    <?= str_repeat("●", strlen($data["password"] ?? "")) ?>
                </div>
            </div>

            <div class="row">
                <div class="label">性別</div>
                <div class="value">
                    <?= ($data["gender"] ?? "") === "0" ? "男" : "女" ?>
                </div>
            </div>

            <div class="row">
                <div class="label">郵便番号</div>
                <div class="value">
                    <?= h($data["postal_code"] ?? "") ?>
                </div>
            </div>

            <div class="row">
                <div class="label">住所（都道府県）</div>
                <div class="value">
                    <?= h($data["prefecture"] ?? "") ?>
                </div>
            </div>

            <div class="row">
                <div class="label">市区町村</div>
                <div class="value">
                    <?= h($data["address_1"] ?? "") ?>
                </div>
            </div>

            <div class="row">
                <div class="label">番地</div>
                <div class="value">
                    <?= h($data["address_2"] ?? "") ?>
                </div>
            </div>

            <div class="row">
                <div class="label">アカウント権限</div>
                <div class="value">
                    <?= ($data["authority"] ?? "") === "1" ? "管理者" : "一般" ?>
                </div>
            </div>

            <div class="button-area">

                <!-- 戻る -->
                <form action="update.php" method="get">

                    <input
                        type="hidden"
                        name="id"
                        value="<?= h($data["id"] ?? "") ?>"
                    >

                    <button type="submit">
                        前に戻る
                    </button>

                </form>

                <!-- 更新 -->
                <form action="update_complete.php" method="post">

                    <?php foreach ($data as $key => $value): ?>

                        <input
                            type="hidden"
                            name="<?= h($key) ?>"
                            value="<?= h($value) ?>"
                        >

                    <?php endforeach; ?>

                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= $_SESSION['csrf_token'] ?>"
                    >

                    <button type="submit">
                        更新する
                    </button>

                </form>

            </div>

        </div>

        <div class="footer">
            フッター
        </div>

    </div>

</div>

</body>
</html>