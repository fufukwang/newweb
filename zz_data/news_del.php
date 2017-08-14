<?
//載入資料庫連結
include("db.php");
?>
<?
//把抓到的nid 帶入 $nid變數中
  $nid=$_GET['nid'];  
?>
<?
//刪除資料
$query_str = "DELETE FROM news_data WHERE news_id='$nid'";
mysql_query($query_str)or die(mysql_error());//刪除資料 mysql_query 是執行語法
?>
<?
//自動導向結果頁
if (1==1){
$url = "msg_del.php";
echo "<script type='text/javascript'>";
echo "window.location.href='$url'";
echo "</script>";
} 
?> 
