<?php
	session_start();
	session_regenerate_id(true);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>注文登録</title>
  </head>
<body>

<?php

try
{
require_once('../common/common.php');

$post=sanitize($_POST);

$onamae=$post['onamae'];
$email=$post['email'];
$postal1=$post['postal1'];
$postal2=$post['postal2'];
$address=$post['address'];
$tel=$post['tel'];

print $onamae.'様 <br>';
print 'ご注文ありがとうございました。<br>';
print $email.'にメールを送りましたのでご確認ください。<br>';
print '商品は以下の住所に発送させていただきます。<br>';
print $postal1.'-'.$postal2.'<br>';
print $address.'<br>';
print $tel.'<br>';

$honbun='';
$honbun.=$onamae."様\n\nこのたびはご注文ありがとうございました。\n";
$honbun.="\n";
$honbun.="ご注文商品\n";
$honbun.="----------\n";

$cart=$_SESSION['cart'];
$kazu=$_SESSION['kazu'];
$max=count($cart);

$dsn='mysql:dbname=shop;host=localhost;charset=utf8'; //DB接続コピペ
$user='root';
$password='123456';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

for($i=0;$i<$max;$i++)
{
	$sql='SELECT name,price FROM mst_product WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[0]=$val;
    $stmt->execute($data);

    $rec=$stmt->fetch(PDO::FETCH_ASSOC);

	$name=$rec['name'];
	$price=$rec['price'];
	$suryo=$kazu[$i];
	$shokei=$price*$suryo;
}	

$dbh=null;

$honbun.="送料は無料です。\n";
$honbun.="-----------\n";
$honbun.="\n";
$honbun.="代金は以下の口座にお振込みください。\n";
$honbun.="ろくまる銀行　やさい支店　普通口座　1234567\n";
$honbun.="入金確認が取れ次第、梱包、発送させていただきます。\n";
$honbun.="\n";
$honbun.="□□□□□□□□□□□□□□□□□□□□□□□□□□\n";
$honbun.="　～安心野菜のろくまる農園～\n";
$honbun.="\n";
$honbun.="〇〇県六丸郡六丸村　123-4\n";
$honbun.="電話　090-6060-xxxx\n";
$honbun.="メール　info@example.com\n";
$honbun.="□□□□□□□□□□□□□□□□□□□□□□□□□□\n";
//print '<br>';
//print nl2br($honbun);

$title='ご注文ありがとうございます。'; //顧客にメール送信
$header='From: info@example.com';
$honbun=html_entity_decode($honbun,ENT_QUOTES,'UTF-8');
mb_language('Japanese');
mb_internal_encoding('UTF-8');
mb_send_mail($email,$title,$honbun,$header);

$title='お客様からご注文がありました。'; //店にメール送信
$header='From:'.$email;
$honbun=html_entity_decode($honbun,ENT_QUOTES,'UTF-8');
mb_language('Japanese');
mb_internal_encoding('UTF-8');
mb_send_mail('info@example.com',$title,$honbun,$header);

}
catch(Exception $e)
{
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>
</body>
</html>