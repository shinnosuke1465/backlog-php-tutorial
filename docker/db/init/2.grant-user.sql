-- dbにアクセスするユーザーの定義。udemy_user...ユーザー名。udemy_pass...パスワード
CREATE USER 'udemy_user'@'%' IDENTIFIED BY 'udemy_pass';

-- 権限の設定。udemy_useはudemy_dbに対して全ての権限を持つ
GRANT ALL PRIVILEGES ON udemy_db.* TO 'udemy_user'@'%' WITH GRANT OPTION;

-- 上記の内容をsqlに反映させる
FLUSH PRIVILEGES;
