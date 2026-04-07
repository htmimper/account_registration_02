<?php
$pdo = new PDO('mysql:host=localhost;dbname=di_blog;charset=utf8', 'root', 'mysql');

// accounts テーブルから取得（ID降順）
$sql = "SELECT * FROM accounts ORDER BY id DESC";
$stmt = $pdo->query($sql);
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>アカウント一覧</title>
</head>
<body>

<h2>アカウント一覧</h2>

<table border="1">
<tr>
  <th>ID</th>
  <th>姓</th>
  <th>名</th>
  <th>カナ（姓）</th>
  <th>カナ（名）</th>
  <th>メール</th>
  <th>性別</th>
  <th>アカウント権限</th>
  <th>削除フラグ</th>
  <th>登録日時</th>
  <th>更新日時</th>
  <th>更新</th>
  <th>削除</th>
</tr>

<?php foreach($accounts as $row): ?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><?= $row['family_name'] ?></td>
  <td><?= $row['last_name'] ?></td>
  <td><?= $row['family_name_kana'] ?></td>
  <td><?= $row['last_name_kana'] ?></td>
  <td><?= $row['mail'] ?></td>

  <!-- 性別 -->
  <td><?= $row['gender'] == 0 ? '男' : '女' ?></td>

  <!-- アカウント権限 -->
  <td><?= $row['authority'] == 0 ? '一般' : '管理者' ?></td>

  <!-- 削除フラグ -->
  <td><?= $row['delete_flag'] == 0 ? '有効' : '無効' ?></td>

  <!-- 登録日時 -->
  <td><?= date('Y-m-d', strtotime($row['registered_time'])) ?></td>
  <td><?= date('Y-m-d', strtotime($row['update_time'])) ?></td>

  <!-- 更新日時-->
  <td>
    <a href="update.php?id=<?= $row['id'] ?>">
      <button>更新</button>
    </a>
  </td>

  <!-- 削除 -->
  <td>
    <a href="delete.php?id=<?= $row['id'] ?>">
      <button>削除</button>
    </a>
  </td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>