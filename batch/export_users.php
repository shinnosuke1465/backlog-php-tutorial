<!-- データベースを扱うバッチ -->
<?php
// データベース接続
$username = "udemy_user";
$password = "udemy_pass";
$hostname = "db";
$db = "udemy_db";
$pdo = new PDO("mysql:host={$hostname};dbname={$db};charset=utf8", $username, $password);

// 社員情報取得SQLの実行
$sql = "SELECT * FROM users ORDER BY id";
// これはSQL文を定義する行です。このSQL文は「usersテーブルから全てのデータを取得し、それをidでソートする」という操作を意味しています。「SELECT * FROM」は「全てのカラムのデータを取得する」という操作を表しています。

$stmt = $pdo->prepare($sql);
// この行では、PDO（PHP Data Objects）インスタンスのprepareメソッドを用いて、先ほど定義したSQL文を準備します。prepareメソッドは、SQL文を実行するためのステートメントを準備します。ステートメントとは、SQL文とそれに対応するパラメータを結びつけるものです。

$stmt->execute();
// この行では、準備したステートメントを実際に実行します。この結果、SQL文がデータベースに送られ、指定された操作（この場合はデータの取得）が行われます。

// SQL結果を1行ずつ読み込み、終端まで折り返し
$outputData = [];
$dataCount = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  // whileループは、$stmt->fetch(PDO::FETCH_ASSOC)がfalse（つまりデータの終端）を返すまで実行されます。$stmt->fetch(PDO::FETCH_ASSOC)は、結果セットから次の行を取得し、それを連想配列として返します。連想配列のキーはデータベースのカラム名に対応しています。

  // PDO::FETCH_ASSOCは、PDO（PHP Data Objects）で定義された定数で、結果を連想配列形式で取得することを指示します。この指定があるため、各行はカラム名をキーとする配列として取得されます。

  // 出力データ作成

  $outputData[$dataCount]["id"] = $row["id"];
  $outputData[$dataCount]["name"] = $row["name"];
  $outputData[$dataCount]["name_kana"] = $row["name_kana"];
  $outputData[$dataCount]["birthday"] = $row["birthday"];
  $outputData[$dataCount]["gender"] = $row["gender"];
  $outputData[$dataCount]["organization"] = $row["organization"];
  $outputData[$dataCount]["post"] = $row["post"];
  $outputData[$dataCount]["start_date"] = $row["start_date"];
  $outputData[$dataCount]["tel"] = $row["tel"];
  $outputData[$dataCount]["mail_address"] = $row["mail_address"];
  $outputData[$dataCount]["created"] = $row["created"];
  $outputData[$dataCount]["updated"] = $row["updated"];
  $dataCount++;
  // var_dump($row);
}

// debug
// var_dump($outputData);

// 出力ファイルオープン
$fpOut = fopen(__DIR__ . "/export_users.csv", "w");

// ヘッダー行書き込み
$header = [
  "社員番号",
  "社員名",
  "社員名カナ",
  "生年月日",
  "性別",
  "所属部署",
  "役職",
  "入社年月日",
  "電話番号",
  "メールアドレス",
  "作成日時",
  "更新日時"
];

fputcsv($fpOut, $header);

// 出力データ数文 繰り返し
foreach ($outputData as $data) {
  // 出力データ書き込み
  fputcsv($fpOut, $data);
}

// 出力ファイルクローズ
fclose($fpOut);
?>