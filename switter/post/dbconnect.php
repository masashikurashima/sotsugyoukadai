<?php
try {
    $db =new PDO('mysql:host=localhost;dbname=switter;charset=utf8','root','');
} catch (PDOException $e){
    echo 'DB接続エラー：'. $e ->getMessage();
}
?>
