<?
require_once("db/mmhConf.php"); //載入檔案
?>
<?
//接收資料
  if ($_POST['mid']!= ''){
  $mid=$_POST['mid'];
  }
  $id_name=$_POST['id_name'];
  $user_name=$_POST['user_name'];
  $password=$_POST['password'];
  $mpower=$_POST['mpower'];
  $busin_power=$_POST['busin_power'];
  $house_power=$_POST['house_power'];
  $super_power=$_POST['super_power'];
//  $ppower=$_POST['ppower'];
//  $apower=$_POST['apower']; 
//  $cpower=$_POST['cpower'];
//  $spower=$_POST['spower'];  
//  $mailpower=$_POST['mailpower'];  
?>

<?
//把接收的資料 轉成陣列
$mysql->table = 'member_data'; //指定sql的table 有判斷大小寫
	if ($_POST['password'] == ''){
		$data = array(
				'id_name'    => $id_name,
				'user_name'  => $user_name,
				'mpower'    => $mpower,
				'busin_power'    => $busin_power,
				'house_power'    => $house_power,
				'super_power'    => $super_power,
				'email'     => _post('email')
			);
		}
	else
		{
		$data = array(
				'id_name'    => $id_name,
				'user_name'  => $user_name,
 				'password'    => $password,
				'mpower'    => $mpower,
				'busin_power'    => $busin_power,
				'house_power'    => $house_power,
				'super_power'    => $super_power,
				'email'     => _post('email')
			);	
		}
?>

<?
if ($_POST['mid'] == ''){
//新增資料
$mysql->insert($data);
$msg='新增成功';
$location='member_list.php';
}
else
{
//編輯資料
$mysql->update($data,"WHERE member_id={$mid}");
$msg='編輯成功';
$location='member_list.php';
} 
?>
<?
//自動導向結果頁
if (1==1){
alert_with_location($msg,$location);
} 
?> 
