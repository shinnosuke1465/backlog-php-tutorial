<?php
declare(strict_types=1);

// 共通部分の読込
require_once(dirname(__DIR__) . "/library/common.php");

// セッションの開始
session_start();

if (isset($_SESSION["id"])) {
    header("Location: search.php");
    exit;
}

$loginId = "";
$password = "";
$errorMessage = "";

//POST通信？
if (mb_strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    //ログイン認証SQLの実行
    $loginId = isset($_POST['login_id']) ? $_POST['login_id'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $sql = "SELECT * FROM login_accounts WHERE login_id = :login_id";
    // :login_idに入力された$loginIdをセットする
    $param = [":login_id" => $loginId];
    // 入力された$loginIdと指定したlogin_accountsテーブルをキーとしてDatabaseの中から該当するログインアカウントを探す
    $loginAccount = DataBase::fetch($sql, $param);

    //ログイン認証OK？
    if (empty($loginAccount["id"])) {
      // loginAcountのidから値をとれなかった時
        $errorMessage .= "ログインID、又はパスワードに誤りがあります。";
    } else if (password_verify($password, $loginAccount["password"]) === false) {
      // $passwordが$loginAccountのpasswordと同じかどうか真偽値返す
        $errorMessage .= "ログインID、又はパスワードに誤りがあります。";
    }
    if ($errorMessage === "") {
      // セッションIDの発行
        session_regenerate_id(true);
        $_SESSION["id"] = $loginAccount["id"];
        $_SESSION["login_id"] = $loginAccount["login_id"];
        $_SESSION["name"] = $loginAccount["name"];
        // search.phpに画面を遷移してくださいという命令
        header("Location: search.php");
        exit;
    }

    //ログイン処理

    //社員検索画面に遷移

    //エラーメッセージ表示
    //・例)ログインID、又はパスワードに誤りがあります。
}

//各入力項目表示
$title = "ログイン";
require_once(TEMPLATE_DIR . "login.php");
?>
