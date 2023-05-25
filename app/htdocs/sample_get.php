<?php
echo "通信方式は".$_SERVER['REQUEST_METHOD']."です。";
// $_SERVER['REQUEST_METHOD']はPHPのスーパーグローバル変数の一つで、これを使用すると現在のページに対するリクエストメソッド（GET、POSTなど）を取得できます。通信方式を取得できる
echo "test_param1は".$_GET['test_param1']."です。";
echo "test_param2は".$_GET['test_param2']."です。";
// http://localhost/sample get.php?test param1=aaa&test param2=bbbのaaaとbbbのgetパラメータを取得できる
?>
