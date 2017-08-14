<?
require_once("db/mmhConf.php"); //載入檔案
?>
<?
//判斷是否有抓到 id 如果有,把抓到的id 帶入變數中
  if ($_POST['vid']!= ''){
  $vid=$_POST['vid'];
  }
  $mail=$_POST['mail'];
  $name=$_POST['name']; 
  $create_time = date("Y-m-d H:i:s");
?>

<?
//把接收的資料 轉成陣列
$mysql->table = 'vendors_data'; //指定sql的table 有判斷大小寫
$data = array(
				'email'    => $mail,
				'name'    => $name,
				'create_time'    => $create_time,
				'create_user'    => $_SESSION['user_name']
			);
?>

<?
if ($_POST['vid'] == ''){
//新增資料
$mysql->insert($data);
$msg='新增零件廠商成功';
$location='vendors_list.php';
}
else
{
//編輯資料
$mysql->update($data,"WHERE vendors_id={$vid}");
$msg='編輯零件廠商成功';
$location='vendors_list.php';
} 
?>
<?
//自動導向結果頁
if (1==1){
alert_with_location($msg,$location);
} 
?> 
