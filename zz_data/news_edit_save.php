<?
//載入資料庫連結
include("db.php");
?>
<?
//判斷是否有抓到 news_id 如果有,把抓到的nid 帶入 $nid變數中
  if ($_POST['nid']!= ''){
  $nid=$_POST['nid'];
  }
  $title=$_POST['title'];
  $content=$_POST['content'];
  $inx=$_POST['inx'];
  
?>
<?
//判斷是否有抓到 news_id ,來決定要吃哪一串sql
if ($_POST['nid'] == ''){
$sql = 'select * from news_data'; //抓所有資料
}
else
{
$sql = 'select * from news_data where news_id='.$nid ; //抓news_id 的那一筆資料
}
$rs = mysql_query($sql)or die(mysql_error()); //sql查詢
$news = mysql_fetch_assoc($rs); //建立資料集
?>
<?
if ($_POST['nid'] == ''){
//新增資料
$create_date = date('Y-m-d');
$query_str ="INSERT INTO news_data(title,content,inx,create_date)  VALUES ( '$title','$content','$inx','$create_date')";
}
else
{
//編輯資料
$change_date = date('Y-m-d');
$query_str ="UPDATE news_data SET title='$title',content='$content',inx='$inx',create_date='$create_date' WHERE news_id='$nid'";
} 
mysql_query($query_str)or die(mysql_error());//新增資料 mysql_query 是執行語法
?>
<?
//自動導向結果頁
if (1==1){
$url = "msg.php?nid=".$nid;
echo "<script type='text/javascript'>";
echo "window.location.href='$url'";
echo "</script>";
} 
?> 
