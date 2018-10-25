<?php
require ('dbconnect.php');

session_start();

if (isset($_COOKIE['email']) && $_COOKIE['email'] !=''){
    $_POST['email'] = $_COOKIE['email'];
    $_POST['pass'] = $_COOKIE['pass'];
    $_POST['save'] = 'on';
}

if(!empty($_POST)) {
 if ($_POST['email'] != '' && $_POST['pass'] !=''){
  $login = $db->prepare ('SELECT * FROM member WHERE email=? AND pass=?');
  $login -> execute(array(
     $_POST['email'],
     sha1($_POST['pass'])
  ));
  $member = $login ->fetch();

  if (isset($member)){
    $_SESSION['id'] = $member['id'];
    $_SESSION['time'] = time();

       if(isset($_POST['save'])&& $_POST['save'] == 'on'){
           setcookie('email' , $_POST['email'], time()+60*60*24*14);
           setcookie('pass' , $_POST['pass'], time()+60*60*24*14);
        }

 header('Location: index.php');
 exit();
}  else{
  $error['login'] = 'failed';
}
}else{
  $error['login'] ='blank';
}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Switter</title>
<link rel="stylesheet"href="../css/01.css"type="text/css">

</head>
<body>
<div id = "lead">
  <p>メールアドレスとパスワードを入力してログインしてください</p>
  <p>入会手続きがまだの方はこちらからどうぞ。</a></p>
  <p>&raquo;<a href="join/">入会手続きをする</a></p>
</div>
      <form action="" method="post">
      <dl>
      <dt>メールアドレス</dt>
      <dd>
      <input type="text" name="email" size="35" maxlength="255" value="<?php echo htmlspecialchars(@$_POST['email'],ENT_QUOTES);?>" />
      <?php if (isset($error['login']) && $error['login'] == 'blank'): ?>
        <p class= "error">*メールアドレスとパスワードをご記入ください</p>
      <?php endif; ?>
      <?php if (isset($error['login']) && $error['login'] == 'failed'): ?>
        <p class= "error">*ログインに失敗しました。入力内容をご確認ください</p>
      <?php endif; ?>
      </dd>
      <dt>パスワード</dt>
      <dd>
        <input type="password" name="pass" size="35" maxlength="255" value="<?php echo htmlspecialchars(@$_POST['pass'],ENT_QUOTES);?>" />
      </dd>
      <dt>ログイン情報の記録</dt>
      <dd>
        <input id="save" type="checkbox" name="save" value="on"><label for="save" >次回からは自動的にログインする</label>
        </dd>
    </dl>
    <div><input type="submit" value="ログインする" /></div>
  </form>
</body>
</html>
