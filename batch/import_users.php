<!-- データベースを扱うバッチ -->
<!-- csvファイルの内容をデータベース（sql）に反映 -->
<!-- データベースの内容を更新する時 -->

<?php

// データベース接続
$username = "udemy_user";
$password = "udemy_pass";
$hostname = "db";
$db = "udemy_db";
$pdo = new PDO("mysql:host={$hostname};dbname={$db};charset=utf8", $username, $password);

// 社員情報csvオープン
$fp = fopen(__DIR__ . "/import_user.csv", "r");

// トランザクション開始
$pdo->beginTransaction();

// ファイルを1行ずつ読み込み、終端まで折り返し
while ($data = fgetcsv($fp)) {
  // fgetcsv関数を使って、指定したファイルポインタ（ここでは$fp）から行を取得し、その行をカンマで分割して配列にします。このループはファイルの終わりに達するまで繰り返されます。

  // 社員番号をキーに社員情報取得SQLの実行
  $sql = "SELECT COUNT(*) AS count FROM users WHERE id = :id";
  // SQLクエリの文字列を作成します。このクエリは、指定したIDにマッチするレコードの数（COUNT(*)）をデータベースの"users"テーブルから取得します

  $param = [":id" => $data[0]];
  // SQLクエリのパラメータを設定します。ここでは、パラメータ":id"にCSVファイルから取得した社員番号（$data[0]）を設定します。

  $stmt = $pdo->prepare($sql);
  // prepareメソッドを使用して、SQLクエリを準備します。これにより、後からパラメータをバインドしてクエリを実行できます。

  $stmt->execute($param);
  // executeメソッドを使って、準備したSQLクエリを実行します。ここでは先に設定したパラメータ（$param）を使います。

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  // fetchメソッドを使用して、結果セットから次の行を取得します。PDO::FETCH_ASSOCは取得する行を連想配列として返すことを示します。

  // // debug
  // var_dump($data[0]);
  // var_dump($result);

  // SQLの結果件数は0件？
  if($result["count"] === "0"){
  // 社員情報更新SQLの実行
    var_dump($data[0]);
    var_dump(("登録"));
  }else{
  // 社員情報登録SQLの実行
  var_dump($data[0]);
  var_dump(("更新"));
  }
}

// コミット
$pdo->commit();
// 社員情報のCSVクローズ
fclose($fp);
?>