<?
require_once("db/mmhConf.php"); //載入檔案
?>
<?
//判斷是否有抓到 id 如果有,把抓到的id 帶入變數中
  if ($_GET['pid']!= ''){
  $pid=$_GET['pid'];
  }
?>

<?
$mysql->table = 'vendors_data'; //指定sql的table 有判斷大小寫
//刪除資料
$mysql->del("WHERE vendors_id={$pid}");
$msg='刪除成功';
$location='vendors_list.php';
?>
<?
//自動導向結果頁
if (1==1){
alert_with_location($msg,$location);
} 
?> 

