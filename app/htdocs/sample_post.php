<?php
echo "通信方式は".$_SERVER['REQUEST_METHOD']."です。";
// 下記の入力項目のnameを参照 
echo "test_param1は".$_POST['user_id']."です。";
echo "test_param2は".$_POST['password']."です。";

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<form action="sample_post.php" method="post">
ユーザーID：<input type="text" name="user_id" /><br/>
パスワード：<input type="password" name="password" /><br/>
<input type="submit" value="送信"/>
</form>
</body>
</html>