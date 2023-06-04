<?php 
declare(strict_types=1);

session_start();

// ログアウト処理

// セッション変数の削除
$_SESSION = [];

// cookieの削除
setcookie("PHPSESSID","",time() - 1800, "/");

// セッションの破棄
session_destroy();

// ログイン画面に遷移
?>