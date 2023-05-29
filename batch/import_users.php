<!-- データベースを扱うバッチ -->
<!-- csvファイル（import_users.csv）の内容をデータベース（sql）に反映させる -->
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

  // 社員番号をキーに社員情報取得SQLの実行
  $sql = "SELECT COUNT(*) AS count FROM users WHERE id = :id";
  // SQLクエリの文字列を作成します。このクエリは、指定したIDにマッチするレコードの数（COUNT(*)）をデータベースの"users"テーブルから取得します

  $param = [":id" => $data[0]];
  // SQLクエリのパラメータを設定します。ここでは、パラメータ":id"にCSVファイルから取得した社員番号（$data[0]）を設定します。

  $stmt = $pdo->prepare($sql);
  // sqlの準備

  $stmt->execute($param);
  // sqlの実行

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  // fetchメソッドを使用して、結果セットから次の行を取得します。PDO::FETCH_ASSOCは取得する行を連想配列として返すことを示します。

  // SQLの結果件数は0件？
  if ($result["count"] === "0") {
    // 社員情報更新SQLの実行
    // var_dump($data[0]);
    // var_dump(("登録"));

    // データの登録
    $sql = "INSERT INTO users (";
    $sql .= " id, ";
    $sql .= " name, ";
    $sql .= " name_kana, ";
    $sql .= " birthday, ";
    $sql .= " gender, ";
    $sql .= " organization, ";
    $sql .= " post, ";
    $sql .= " start_date, ";
    $sql .= " tel, ";
    $sql .= " mail_address, ";
    $sql .= " created, ";
    $sql .= " updated, ";
    $sql .= ") VALUES (";
    $sql .= " :id, ";
    $sql .= " :name, ";
    $sql .= " :name_kana, ";
    $sql .= " :birthday, ";
    $sql .= " :gender, ";
    $sql .= " :organization, ";
    $sql .= " :post, ";
    $sql .= " :start_date, ";
    $sql .= " :tel, ";
    $sql .= " :mail_address, ";
    $sql .= " NOW(), "; //作成日時
    $sql .= " NOW() "; //更新日時
    $sql .= ") ";
  } else {
    // 社員情報登録SQLの実行
    // var_dump($data[0]);
    // var_dump(("更新"));

    // データの更新
    $sql = "UPDATE users ";
    $sql = "SET name = :name, ";
    $sql .= " name_kana = :name_kana, ";
    $sql .= " birthday = :birthday, ";
    $sql .= " gender = :gender, ";
    $sql .= " organization = :organization, ";
    $sql .= " post = :post, ";
    $sql .= " start_date = :start_date, ";
    $sql .= " tel = :tel, ";
    $sql .= " mail_address = :mail_address, ";
    $sql .= " updated = NOW() "; //作成日時 
    $sql .= " WHERE id  = :id "; //作成日時 
  }
  $param = array(
    "id" => $data[0],
    "name" => $data[1],
    "name_kana" => $data[2],
    "birthday" => $data[3],
    "gender" => $data[4],
    "organization" => $data[5],
    "post" => $data[6],
    "start_date" => $data[7],
    "tel" => $data[8],
    "mail_address" => $data[9],
  );
  $stmt = $pdo->prepare($sql);
  $stmt->prepare($param);
}

// コミット
$pdo->commit();
// 社員情報のCSVクローズ
fclose($fp);
?>