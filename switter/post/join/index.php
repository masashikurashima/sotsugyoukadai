<?php
require ('../dbconnect.php');
session_start();

if (empty($_POST)) {
$error = array('name' => '', 'pass' => '', 'email' => '');
} else {
  if ($_POST['name'] == ''){
      $error['name'] ='blank';
  }
  if ($_POST['email'] == ''){
      $error['email'] ='blank';
  }


  if(!filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL)){
       $error['email'] ='badmail';
  }

  if (strlen($_POST['pass']) < 4) {
      $error['pass'] ='length';
  }
  if ($_POST['pass'] == ''){
    $error['pass'] ='blank';
  }



  if(empty($error)) {
    $member = $db -> prepare('SELECT COUNT(*) AS cnt FROM member WHERE email=?');
    $member -> execute(array($_POST['email']));
    $recode = $member -> fetch();
    if ($recode['cnt'] > 0) {
        $error['email'] = 'duplicate';
    }
  }

  if(empty($error)) {
    $_SESSION['join'] = $_POST;
    header('Location: check.php');
    exit();
  }
}

if (isset($_REQUEST['action']) &&  $_REQUEST['action']== 'rewrite') {
  $_POST = $_SESSION['join'];
  $error['rewrite'] = true;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Switter</title>
<link rel="stylesheet"href="../../css/01.css"type="text/css">
</head>
<body>
  <p>新規アカウント作成</p>

<form action="" method="post" enctype="multipart/form-data">
  <dl>
    <dt>ニックネーム<span class="required">必須</span></dt>
      <dd>
        <input type="text" name="name" style="width:100px" maxlength="255" value="<?php echo htmlspecialchars(@$_POST['name'], ENT_QUOTES); ?>" />
        <?php if (isset($error['name']) && $error['name'] == 'blank'):?>
          <p class="error">*ニックネームを入力してください</p>
        <?php endif; ?>
      </dd>

    <dt>メールアドレス<span class="required">必須</span></dt>
      <dd>
        <input name="email"　type="text"　style="width:100px" maxlength="255" value="<?php echo htmlspecialchars(@$_POST['email'],ENT_QUOTES); ?>"/>
        <?php if(isset($error['email']) && $error['email'] == 'blank'): ?>
        <p class="error">*メールアドレスを入力してください</p>
        <?php endif; ?>

        <?php if(isset($error['email']) && $error['email'] == 'badmail'): ?>
        <p class="error">*メールアドレスを正しく入力してください</p>
        <?php endif; ?>

        <?php if (isset($error['email']) && $error['email'] == 'duplicate') :?>
        <p class="error">*指定されたメールアドレスは既に登録されています</p>
        <?php endif; ?>
      </dd>

    <dt>パスワード<span class="required">必須</span></dt>
    <dd>
        <input name="pass"type="password"style="width:100px" maxlength="20"　value="<?php echo htmlspecialchars(@$_POST['pass'],ENT_QUOTES); ?>" />
        <?php if(isset($error['pass']) && $error['pass'] == 'blank'): ?>
        <p class="error">*パスワードを入力してください</p>
        <?php endif; ?>
        <?php if(isset($error['pass']) && $error['pass'] == 'length'): ?>
        <p class="error">*パスワードは4文字以上で入力してください</p>
    　  <?php endif; ?>
      </dd>
    </dl>
<biv><input type="submit" value="入力内容を確認する"></div>
</form>
</body>
</html>
