<body>
  <h2>メモを登録</h2>

  <form method="post" action="./store.php">

    <div>
      <label for="name">title
        <input type="text" name="title" placeholder="タイトル">
      </label>
    </div>

    <div>
      <label for="content">本文
        <input type="textarea" name="content" placeholder="本文">
      </label>
    </div>

    <button type="submit">送信</button>

  </form>
</body>