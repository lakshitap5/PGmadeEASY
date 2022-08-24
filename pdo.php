<?php
/*$host = 'localhost';
$db = 'pg';
$user = 'admin';
$pass = 'default';
$dsn = "mysql:host=$host;port=3306;dbname=$db";
$pdo = new PDO($dsn, $user, $pass);*/
#$pdo = new PDO('mysql:host=localhost;port=3306;dbname=pg','admin','default');

$host = 'remotemysql.com';
$db = 'r0Ea9qzG8m';
$user = 'r0Ea9qzG8m';
$pass = 'QB4OaD7S27';
$dsn = "mysql:host=$host;port=3306;dbname=$db";
$pdo = new PDO($dsn, $user, $pass);

$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
