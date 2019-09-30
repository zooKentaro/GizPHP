<?php
require_once('functions.php');
setToken();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>編集</title>
</head>
<body>
  <?php if (!empty($_SESSION['err'])) : ?>
    <P> <?= $_SESSION['err']; ?></P>
  <?php endif; ?>
  <form action="store.php" method="post">
    <input type="hidden" name="token" value="<?= e($_SESSION['token']); ?>">
    <input type="hidden" name="id" value="<?= e($_GET['id']); ?>">
    <input type="text" name="todo" value="<?= e(getSelectedTodo($_GET['id'])); ?>">
    <input type="submit" value="更新">
  </form>
  <div>
    <a href="index.php">一覧へもどる</a>
  </div>
  <?php unsetSession(); ?>
</body>
</html>
