<?
require_once("db/mmhConf.php"); //載入檔案
?>
<?
//判斷是否有抓到 id 如果有,把抓到的id 帶入變數中
  if ($_GET['nid']!= ''){
  $nid=$_GET['nid'];
  } 
?>

<?
//把接收的資料 轉成陣列
$mysql->table = 'parts_needs_data'; //指定sql的table 有判斷大小寫
$data = array(
				'visible'    => 1
			);
?>

<?
if ($_GET['nid'] != ''){
//編輯資料
$mysql->update($data,"WHERE needs_id={$nid}");
$msg='審核成功';
$location='parts_needs_list.php';
} 
?>
<?
//自動導向結果頁
if (1==1){
alert_with_location($msg,$location);
} 
?> 
