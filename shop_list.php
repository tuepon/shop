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
    <title>商品一覧</title>
  </head>
<body>

<?php

try
{

$dsn='mysql:dbname=shop;host=localhost;charset=utf8'; //DB接続コピペ
$user='root';
$password='123456';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT code,name,price FROM mst_product WHERE 1';
$stmt=$dbh->prepare($sql);
$stmt->execute();

$dbh=null; //DB切断

print '商品一覧<br><br>';


while(true)
{
    $rec=$stmt->fetch(PDO::FETCH_ASSOC); //データ取得
    if($rec==false)
    {
        break;
    }
    print '<a href="shop_product.php?procode='.$rec['code'].'">';
    print $rec['name'].'---';
    print $rec['price'].'円';
    print '</a>';
    print '<br>';
}
}
catch (Exception $e)
{
    print 'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}

?>

</body>
</html>