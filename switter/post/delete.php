<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {
   $id = $_REQUEST['id'];

   $messages = $db ->prepare('SELECT * FROM posts WHERE id=?');
   $messages -> execute(array($id));
   $message =$messages->fetch();

   if(isset($message['member_id']) && $message['member_id'] == $_SESSION['id']) {
     $del = $db->prepare('UPDATE posts SET del = 1 WHERE id=?');
     $del ->execute(array($id));
   }
}


$ref = $_SERVER['HTTP_REFERER'];
if (strpos($ref,'index')) {
header('Location: index.php');
 } else {
header('Location: mypost.php');
}

?>
