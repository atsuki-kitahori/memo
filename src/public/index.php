<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=memo; charset=utf8',
    $dbUserName,
    $dbPassword
);

$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if ($search) {
    $sql = 'SELECT * FROM pages WHERE title LIKE :search';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':search', "%{$search}%", PDO::PARAM_STR);
} else {
    $sql = 'SELECT * FROM pages';
    $statement = $pdo->prepare($sql);
}

$statement->execute();
$pages = $statement->fetchAll(PDO::FETCH_ASSOC);

$standard_key_array = [];
foreach ($pages as $key => $value) {
    $standard_key_array[$key] = $value['created_at'];
}
array_multisort($standard_key_array, SORT_DESC, $pages);
?>

<body>

  <div>
    <a href="./create.php">メモを追加</a><br>
  </div>

  <div>
    <form method="GET" action="./index.php">
      <input type="text" name="search" placeholder="タイトルで検索">
      <button type="submit">検索</button>
    </form>
  </div>

  <div>
    <table border="1">
      <tr>
        <th>タイトル</th>
        <th>内容</th>
        <th>作成日時</th>
        <th>編集</th>
        <th>削除</th>
      </tr>

      <?php foreach ($pages as $page): ?>
        <tr>
          <td><?php echo $page['title']; ?></td>
          <td><?php echo $page['content']; ?></td>
          <td><?php echo date(
              'Y年m月d日H時i分s秒',
              strtotime($page['created_at'])
          ); ?></td>
          <td><a href="./edit.php?id=<?php echo $page['id']; ?>">編集</a></td>
          <td><a href="./delete.php?id=<?php echo $page['id']; ?>">削除</a></td>
        </tr>
      <?php endforeach; ?>

    </table>
  </div>

</body>