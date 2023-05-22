#使用するdocker imageの指定。php:8.0.16-apacheを使用して環境を構築
FROM php:8.0.16-apache

ENV TZ Asia/Tokyo
#webに公開するファイルの指定
ENV APACHE_DOCUMENT_ROOT /udemy/app/htdocs

RUN mkdir /docker-php-udemy
WORKDIR /docker-php-udemy

#php.iniを指定の場所にコピーする
COPY ./php.ini /usr/local/etc/php/conf.d/php.ini

#timezoneの設定。日本時刻を使用
RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime \
  && echo ${TZ} > /etc/timezone

#今回使うソフトウェアのインストール
RUN apt-get update \
  && apt-get install -y \
    cron \
    vim \
  && docker-php-ext-install pdo_mysql

#下記のコードを配布することで誰でも同じ環境を設定できる
RUN sed -ri -e \
  's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
  /etc/apache2/sites-available/*.conf

RUN sed -ri -e \
  's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \ 
  /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
