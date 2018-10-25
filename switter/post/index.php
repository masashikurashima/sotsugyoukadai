<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
  $_SESSION['time'] = time();

  $member = $db->prepare('SELECT * FROM member WHERE id=?');
  $member ->execute(array($_SESSION['id']));
  $member = $member ->fetch();
} else {
  header('Location: login.php') ; exit();
}

if(!empty($_POST)) {
  if($_POST['message'] !=''){
    $message = $db ->prepare('INSERT INTO posts SET member_id=?, message=?, created=NOW()');
    $message -> execute(array(
      $member['id'],
      $_POST['message']
    ));

    header('Location: index.php'); exit();
  }
}

$posts = $db ->query('SELECT m.name, p.* FROM member m, posts p WHERE m.id=p.member_id AND del=0 ORDER BY p.created DESC');

function h($value){
  return htmlspecialchars($value, ENT_QUOTES);
}

function makeLink($value){
  return mb_ereg_replace("(https?)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)",'<a href="\1\2" target="_blank">\1\2</a>',$value);
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8N">
<title>Switter</title>
<link rel="stylesheet"href="../css/01.css"type="text/css">
</head>

<body>
<!-- ログアウト -->
<div style="text-align: right"><a href="logout.php">ログアウト</a></div>

<!-- 投稿 -->
<form action="" method="post">
  <dl>
  <dt><?php echo h($member['name']); ?>さん、ようこそ！<br>メッセージをどうぞ</dt>
  <dd>
   <textarea name="message" cols="50" rows="7" maxlength="150" placeholder="いまの気持ちをつぶやきましょう(150文字以内)"></textarea>
  </dd>
  </dl>
  <div>
   <p><input type="submit" value="投稿する" /></P>
  </div>
</form>
全ての投稿

<a href="mypost.php">私の投稿</a>

<!-- 投稿を表示 -->
<?php foreach ($posts as $post): ?>
<div class="msg">
  <p><?php echo makeLink(h($post['message'])); ?>
  <span class="name">【<?php echo h($post['name']); ?>】 </span></p>
  <p class="day"><a href="view.php?id=<?php echo h($post['id']); ?>">
  <?php echo h($post['created']); ?></a></p>
  <?php if ($_SESSION['id'] == $post['member_id']): ?>
   [<a href=" delete.php?id=<?php echo h($post['id']); ?>" style="color:#F33;">削除</a>]
  <?php endif ?>
</div>
<?php endforeach; ?>


</body>
</html>
