<?php
// csvファイルのオープンとクローズ
// $fp = fopen("開きたいファイル","モード"); モード： r=読み込み, w:書き込み, a:追記書き込み
// while($data = fgetcsv($fp)){
//   何かしら処理
// }
// fclose($fp);


// 社員情報csvオープン。__DIR__現在のファイルにあるcsvファイル
$fp = fopen(__DIR__ . "/input.csv","r");

// ファイルを1行ずつ読み込み、終端まで折り返し
while ($data = fgetcsv($fp)) {
  var_dump($data);
  // 1行目?
  // 次の行へ進む

  // 男性？
  // 男性人数 = 男性人数 + 1

  // 女性人数 = 女性人数 ＋１
}
// 社員情報csvクローズ
fclose($fp);
?>