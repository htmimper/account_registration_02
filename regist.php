<?php
session_start();

$errors = [];
$data = $_POST ?? [];

$prefectures = [
    '北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県',
    '茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県',
    '新潟県','富山県','石川県','福井県','山梨県','長野県',
    '岐阜県','静岡県','愛知県','三重県',
    '滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県',
    '鳥取県','島根県','岡山県','広島県','山口県',
    '徳島県','香川県','愛媛県','高知県',
    '福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県',
    '沖縄県'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $required = [
        'family_name' => '名前（姓）',
        'last_name' => '名前（名）',
        'family_name_kana' => 'カナ（姓）',
        'last_name_kana' => 'カナ（名）',
        'mail' => 'メールアドレス',
        'password' => 'パスワード',
        'gender' => '性別',
        'postal_code' => '郵便番号',
        'prefecture' => '住所（都道府県）',
        'address_1' => '住所（市区町村）',
        'address_2' => '住所（番地）',
        'authority' => 'アカウント権限'
    ];

    foreach ($required as $key => $label) {
        if (!isset($data[$key]) || $data[$key] === '') {
            $errors[$key] = $label . 'が未入力です。';
        }
    }

    if (!empty($data['postal_code']) && !preg_match('/^\d{7}$/', $data['postal_code'])) {
        $errors['postal_code'] = '郵便番号は7桁の半角数字で入力してください。';
    }

    if (empty($errors)) {
        $_SESSION['form'] = $data;
        header('Location: regist_confirm.php');
        exit;
    }
}
    // 名前（姓・名）
    if (!empty($data['family_name']) && !preg_match('/^[ぁ-ん一-龥]+$/u', $data['family_name'])) {
    $errors['family_name'] = '名前（姓）はひらがな・漢字のみ入力できます。';
    }

    if (!empty($data['last_name']) && !preg_match('/^[ぁ-ん一-龥]+$/u', $data['last_name'])) {
    $errors['last_name'] = '名前（名）はひらがな・漢字のみ入力できます。';
    }

    // カナ
    if (!empty($data['family_name_kana']) && !preg_match('/^[ァ-ヶー]+$/u', $data['family_name_kana'])) {
    $errors['family_name_kana'] = 'カナ（姓）はカタカナのみ入力できます。';
    }

    if (!empty($data['last_name_kana']) && !preg_match('/^[ァ-ヶー]+$/u', $data['last_name_kana'])) {  
    $errors['last_name_kana'] = 'カナ（名）はカタカナのみ入力できます。';
    }

    // パスワード
    if (!empty($data['password']) && !preg_match('/^[a-zA-Z0-9]+$/', $data['password'])) {
    $errors['password'] = 'パスワードは半角英数字のみ入力できます。';
    }

    // メール
    if (!empty($data['mail']) && !preg_match('/^[a-zA-Z0-9\-@.]+$/', $data['mail'])) {
    $errors['mail'] = 'メールアドレスの形式が正しくありません。';
    }

    // 住所
    if (!empty($data['address_1']) && !preg_match('/^[ぁ-んァ-ヶ一-龥0-9\- ]+$/u', $data['address_1'])) {
    $errors['address_1'] = '住所（市区町村）に使用できない文字があります。';
    }

    if (!empty($data['address_2']) && !preg_match('/^[ぁ-んァ-ヶ一-龥0-9\- ]+$/u', $data['address_2'])) {
    $errors['address_2'] = '住所（番地）に使用できない文字があります。';
    }

?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>アカウント登録</title>
<link rel="stylesheet" href="regist.css">
</head>
    
<body>
    <header>
        ナビゲーションバー
    </header>
    
<h1>アカウント登録</h1>
<div class="form-area">
<form method="post">

名前（姓）<br>
<div class="form-row">
    <input type="text" name="family_name" maxlength="10"
           value="<?= htmlspecialchars($data['family_name'] ?? '') ?>">
</div>
    <div class="error"><?= $errors['family_name'] ?? '' ?>
    </div>

名前（名）<br>
<div class="form-row">
    <input type="text" name="last_name" maxlength="10"
           value="<?= htmlspecialchars($data['last_name'] ?? '') ?>">
</div>
    <div class="error"><?= $errors['last_name'] ?? '' ?>
    </div>

カナ（姓）<br>
<div class="form-row">
    <input type="text" name="family_name_kana" maxlength="10"
           value="<?= htmlspecialchars($data['family_name_kana'] ?? '') ?>">
    </div>
    <div class="error"><?= $errors['family_name_kana'] ?? '' ?>
    </div>

カナ（名）<br>
    <div class="form-row">
        <input type="text" name="last_name_kana" maxlength="10"
               value="<?= htmlspecialchars($data['last_name_kana'] ?? '') ?>">
        </div>
    <div class="error">
        <?= $errors['last_name_kana'] ?? '' ?>
    </div>

メールアドレス<br>
    <div class="form-row">
        <input type="text" name="mail" maxlength="100"
               value="<?= htmlspecialchars($data['mail'] ?? '') ?>">
    </div>
    <div class="error"><?= $errors['mail'] ?? '' ?>
    </div>

パスワード<br>
    <div class="form-row">
        <input type="password" name="password" maxlength="10">
    </div>
    <div class="error"><?= $errors['password'] ?? '' ?>
    </div>

性別<br>
        <input type="radio" name="gender" value="0"
               <?= ($data['gender'] ?? '0') === '0' ? 'checked' : '' ?>>男
        <input type="radio" name="gender" value="1"
               <?= ($data['gender'] ?? '') === '1' ? 'checked' : '' ?>>女
    <div class="error"><?= $errors['gender'] ?? '' ?>
    </div>

郵便番号<br>
    <div class="form-row">
        <input type="text" name="postal_code" maxlength="7"
               value="<?= htmlspecialchars($data['postal_code'] ?? '') ?>">
    </div>
    <div class="error"><?= $errors['postal_code'] ?? '' ?>
    </div>

住所（都道府県）<br>
    <div class="form-row">
        <select name="prefecture">
            <option value="">選択してください</option>
            <?php foreach ($prefectures as $pref): ?>
            <option value="<?= $pref ?>"
                    <?= ($data['prefecture'] ?? '') === $pref ? 'selected' : '' ?>>
                <?= $pref ?>
            </option>
            <?php endforeach; ?>
        </select>
        </div>
    <div class="error">
        <?= $errors['prefecture'] ?? '' ?>
    </div>

住所（市区町村）<br>
    <div class="form-row">
        <input type="text" name="address_1" maxlength="10"
               value="<?= htmlspecialchars($data['address_1'] ?? '') ?>">
    </div>
    <div class="error">
        <?= $errors['address_1'] ?? '' ?>
    </div>

住所（番地）<br>
    <div class="form-row">
        <input type="text" name="address_2" maxlength="100"
               value="<?= htmlspecialchars($data['address_2'] ?? '') ?>">
    </div>
    <div class="error">
        <?= $errors['address_2'] ?? '' ?>
    </div>

アカウント権限<br>
    <div class="form-row">
    <select name="authority">
        <option value="0" <?= ($data['authority'] ?? '0') === '0' ? 'selected' : '' ?>>一般</option>
        <option value="1" <?= ($data['authority'] ?? '') === '1' ? 'selected' : '' ?>>管理者</option></select>
    </div>
<div class="error"><?= $errors['authority'] ?? '' ?></div>

<br><br>
<button type="submit">確認する</button>
</form>
</div>  
<footer>
    フッター
</footer>
</body>
</html>
