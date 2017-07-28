<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false)
{
    print 'ようこそゲスト様  ';
    print '<a href="member_login.html"> 会員ログイン </a>';
    print '<br>';
}
else
{
    print 'ようこそ';
    print $_SESSION['member_name'];
    print '様  ';
    print '<a href="member_logout.html"> ログアウト </a><br>';
    print '<br>';
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>商品情報参照</title>
  </head>
<body>

<?php

try
{

//$pro_code=$_GET['procode'];
$cart=$_SESSION['cart'];

$dsn='mysql:dbname=shop;host=localhost;charset=utf8'; //DB接続コピペ
$user='root';
$password='123456';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}
catch(Exception $e)
{
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

<form>
<input type="button" onclick="history.back()" value="戻る">
</form>

</body>
</html>