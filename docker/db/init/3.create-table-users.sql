USE udemy_db;
-- 社員データを保存するuserテーブルを定義。varchar...文字列型。date...日付。detetame...日付と時刻
CREATE TABLE `users` (
  `id`           VARCHAR(10) NOT NULL,
  `name`         VARCHAR(255) NOT NULL,
  `name_kana`    VARCHAR(255) NOT NULL,
  `birthday`     DATE NOT NULL,
  `gender`       VARCHAR(10) NOT NULL,
  `organization` VARCHAR(20) NOT NULL,
  `post`         VARCHAR(20) NOT NULL,
  `start_date`   DATE NOT NULL,
  `tel`          VARCHAR(20) NOT NULL,
  `mail_address` VARCHAR(255) NOT NULL,
  `created`      DATETIME,
  `updated`      DATETIME,
  CONSTRAINT PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_bin;
