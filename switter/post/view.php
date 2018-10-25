<?php
session_start();
require('dbconnect.php');

if (empty($_REQUEST['id'])) {
  header('Location: index.php'); exit();
}

$posts = $db ->prepare('SELECT m.name, m.picture, p.* FROM member m, posts p WHERE m.id=p.member_id AND p.id=? ORDER BY p.created DESC');
$posts ->execute(array($_REQUEST['id']));
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8N">
<title>Switter</title>
<link rel="stylesheet"href="../css/01.css"type="text/css">
</head>

<body>
<div style="text-aling: right"><a href="logout.php">ログアウト</a></div>

<div id="wrap">
  <div id="head">
    <h1>Switter</h1>
  </div>
  <div id="content">
    <p>&laquo;<a href="index.php">一覧に戻る</a></p>

<?php
if($post = $posts->fetch ()):
?>
  <div class="msg">
   <p><?php echo htmlspecialchars($post['message'], ENT_QUOTES); ?>
      <span class="name">(<?php echo htmlspecialchars($post['name'], ENT_QUOTES); ?>) </span></p>
   <p class="day"><?php echo htmlspecialchars($post['created'], ENT_QUOTES); ?></p>
  </div>

<?php else: ?>
  <p>その投稿は削除されたか、URLが間違えています</p>
<?php endif;?>
</div>
</div>
</body>
</html>
