<?php
session_start();
require ('../dbconnect.php');
if (!isset($_SESSION['join'])){
  header('Location: index.php');
  exit();
}
if(!empty($_POST)) {
  $statement = $db->prepare('INSERT INTO member(name,email,pass,created) VALUES (?,?,?,NOW())');
    $ret = $statement-> execute(array(
    $_SESSION['join']['name'],
    $_SESSION['join']['email'],
    sha1($_SESSION['join']['pass'])
  ));
  unset($_SESSION['join']);
  header('Location: thanks.php');
  exit();
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8N">
<title>Switter</title>
<link rel="stylesheet"href="../../css/01.css"type="text/css">
</head>
<body>
  <p>新規アカウント作成</p>

<form method="post" action ="">
  <input type="hidden" name="action" value="submit" />
  <dl>
    <dt>ニックネーム</dt>
    <dd>
      <?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES); ?>
    </dd>
    <dt>メールアドレス</dt>
    <dd>
      <?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES); ?>
   </dd>
    <dt>パスワード</dt>
    <dd>
  【表示されません】
  </dd>
  <br>
  </dl>
  <div><a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a>
      | <input type="submit" value="登録する"></div>
</form>
</body>
</html>
