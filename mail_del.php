<?
require_once("db/mmhConf.php"); //載入檔案
?>
<?
//判斷是否有抓到 id 如果有,把抓到的id 帶入變數中
  if ($_GET['mid']!= ''){
  $mid=$_GET['mid'];
  }
  if ($_GET['key']!= ''){
  $key=$_GET['key'];
  }
?>

<?
$mysql->table = 'mail_data'; //指定sql的table 有判斷大小寫
//刪除資料
$mysql->del("WHERE mail_id={$mid}");
$msg='刪除成功';
$location='mail_list.php?key='.$key;
?>
<?
//自動導向結果頁
if (1==1){
alert_with_location($msg,$location);
} 
?> 

