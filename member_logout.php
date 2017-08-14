<?
require_once("db/mmhConf.php"); //載入檔案
?>
<?
//$row[1]=user_name $row[2]=id_name $row[3]=password $row[4]=mpower $row[5]=apower $row[6]=cpower $row[7]=spower
$_SESSION['member_id'] = ""; 
$_SESSION['id_name'] = "";
$_SESSION['user_name'] = "";
$_SESSION['mpower'] = "";
$_SESSION['busin_power'] = "";
$_SESSION['house_power'] = "";
$_SESSION['super_power'] = "";
$msg='登出成功';
$location='index.html';
?>
<?
//自動導向結果頁
if (1==1){
alert_with_location($msg,$location);
} 
?> 
