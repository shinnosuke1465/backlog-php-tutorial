<!-- ファイルの読み込みとファイルの書き込みを行うバッジ -->
<!-- input.csvファイルと読み込みoutput.csvファイルへ書き込み -->

<?php
// csvファイルのオープンとクローズ
// $fp = fopen("開きたいファイル","モード"); モード： r=読み込み, w:書き込み, a:追記書き込み
// while($data = fgetcsv($fp)){
//   何かしら処理
// }
// fclose($fp);


// 社員情報csvオープン。__DIR__現在のファイルにあるcsvファイル
$fp = fopen(__DIR__ . "/input.csv", "r");

// ファイルを1行ずつ読み込み、終端まで折り返し
$lineCount = 0;
$manCount = 0;
$womanCount = 0;
while ($data = fgetcsv($fp)) {
  //データの1行目を飛ばす処理
  $lineCount++;
  // 1行目?
  if ($lineCount === 1) {
    // 次の行へ進む
    continue;
  }
  var_dump($data);


  // 男性か女性か判定してカウントする
  //配列の[4]に情報が入っている
  if ($data[4] === "男性") {
    // 男性人数 = 男性人数 + 1
    $manCount++;
  } else {
    // 女性人数 = 女性人数 ＋１
    $womanCount++;
  }
}
// 社員情報csvクローズ
fclose($fp);

// 出力ファイルオープン
$fpOut = fopen(__DIR__ . "/output.csv", "w");

// ヘッダー行　書き込み
$header = ["男性", "女性"];
fputcsv($fpOut, $header);

// 男性人数、女性人数　書き込み
$outputData = [$manCount, $womanCount];
fputcsv($fpOut, $outputData);

// 出力ファイルクローズ
fclose($fpOut);
?>