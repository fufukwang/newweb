<?
require_once("db/mmhConf.php"); //載入檔案
?>
<?
//接收資料
  if ($_POST['mid']!= ''){
  $mid=$_POST['mid'];
  }
  $name=$_POST['name'];
  $mail=$_POST['mail'];
  $location=$_POST['location'];
  $tag=$_POST['tag'];
  $create_time = date("Y-m-d H:i:s");  
?>

<?
//把接收的資料 轉成陣列
$mysql->table = 'mail_data'; //指定sql的table 有判斷大小寫
		$data = array(
				'name'    => $name,
				'mail'  => $mail,
				'tag'  => $tag,
				'location'  => $location,
				'create_user'    => $_SESSION['user_name'],
				'create_time'    => $create_time
			);	
?>

<?
if ($_POST['mid'] == ''){
//新增資料
$mysql->insert($data);
$msg='新增成功';
$location='mail_list.php?key='.$tag;
}
else
{
//編輯資料
$mysql->update($data,"WHERE mail_id={$mid}");
$msg='編輯成功';
$location='mail_list.php?key='.$tag;
} 
?>
<?
//自動導向結果頁
if (1==1){
alert_with_location($msg,$location);
} 
?> 
