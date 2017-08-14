<?
require_once("db/mmhConf.php"); //載入檔案
?>
<?
//判斷是否有抓到 id 如果有,把抓到的id 帶入變數中
  if ($_GET['rid']!= ''){
  $reserve_id=$_GET['rid'];
  }
  $cancel= 2;
?>

<?
//把接收的資料 轉成陣列
$mysql->table = 'reserve_data'; //指定sql的table 有判斷大小寫
$data = array(
				'cancel'    => $cancel
			);
?>

<?
//編輯資料
$mysql->update($data,"WHERE reserve_id={$reserve_id}");
$msg='取消進貨成功';
?>
<?
//自動導向結果頁
if (1==1){
$location='addition_list.php';	
//$url = "msg.php?nid=".$nid;
$url = "msg.php?msg=".$msg."&url=".$location;
echo "<script type='text/javascript'>";
echo "window.location.href='$url'";
echo "</script>";
} 
?> 
