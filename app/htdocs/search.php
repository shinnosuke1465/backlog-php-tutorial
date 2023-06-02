<?php
declare(strict_types=1);

require_once(dirname(__DIR__) . "/config/config.php");
require_once(dirname(__DIR__) . "/library/validate.php");

// データベース接続
$pdo = new PDO(
  "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);


$id = '';
$nameKana = '';
$gender = '';
$whereSql = '';
$param = [];
$errorMessage = '';
$successMessage = "";

//POST送信かつ削除ボタン押下
//mb_strtolowerz()...引数で渡された（）の中を小文字にする
//現在のHTTPリクエストのリクエストメソッドが「POST」かどうかをチェックしています
//$_SERVER['REQUEST_METHOD']というスーパーグローバル変数を使用してリクエストメソッドを取得
if (mb_strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    //trueならば削除ボタンが押されたということ
    $isDelete = (isset($_POST['delete']) && $_POST['delete'] === '1') ? true : false;

    if ($isDelete === true) {
        //POSTされた社員番号の入力チェック
        $deleteId = isset($_POST['id']) ? $_POST['id'] : '';
        if (!validateRequired($deleteId)) { //空白でないか
            $errorMessage .= '社員番号が不正です。<br>';
        } else if (!validateId($deletedId)) { //6桁の数値か
            $errorMessage .= '社員番号が不正です。<br>';
        } else {
            //存在する社員番号か
            $sql = "SELECT COUNT(*) AS count FROM users WHERE id = :id";
            $param = array("id" => $deleteId);
            $stmt = $pdo->prepare($sql);
            $stmt->execute($param);
            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($count['count'] === '0') {
                $errorMessage .= '社員番号が不正です。<br>';
            }
        }

        //入力チェックOK?
        if ($errorMessage === '') {
            //トランザクション開始
            $pdo->beginTransaction();

            //社員情報の削除
            $sql = "DELETE FROM users WHERE id = :id";
            $param = array("id" => $deleteId);
            $stmt = $pdo->prepare($sql);
            $stmt->execute($param);

            //コミット
            $pdo->commit();

            $successMessage = "削除完了しました。";
        } else {
           // エラー有り
           echo $errorMessage;
        }
    }
}

$param = [];
// 検索条件が指定されている
if (isset($_GET['id']) && isset($_GET['name_kana'])) {
    $id = $_GET['id'];
    $nameKana = $_GET['name_kana'];
    $gender = isset($_GET['gender']) ? $_GET['gender'] : '';

    // 社員番号が入力されている
    if ($id !== '') {
        // 検索条件に社員番号を追加
        $whereSql .= 'AND id = :id ';
        $param['id'] = $id;
    }
    // 社員名カナが入力されている
    if ($nameKana !== '') {
        // 検索条件に社員名カナを追加
        $whereSql .= 'AND name_kana LIKE :name_kana ';
        $param['name_kana'] = $nameKana . '%';
    }
    // 性別が入力されている
    if ($gender !== '') {
        // 検索条件に性別を追加
        $whereSql .= 'AND gender = :gender ';
        $param['gender'] = $gender;
    }
}

//件数取得SQLの実行
$sql = "SELECT COUNT(*) AS count FROM users WHERE 1 = 1 {$whereSql}";
// $param = [];
$stmt = $pdo->prepare($sql);
$stmt->execute($param);
$count = $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($count);

//社員情報取得SQLの実行
$sql = "SELECT * FROM users WHERE 1 = 1 {$whereSql} ORDER BY id";
$stmt = $pdo->prepare($sql);
$stmt->execute($param);
// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     var_dump($row);
// }
require_once(TEMPLATE_DIR . "/template/search.php");
?>
