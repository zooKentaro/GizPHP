<?php
require_once('functions.php');

//$_POSTはpostリクエストで渡された値を受け取るためのスーパーグローバル変数
savePostedData($_POST);
header('Location: ./index.php');
