<?
require_once("db/mmhConf.php"); //載入檔案
?>
<?
//接收資料
  $id_name=$_POST['id_name'];
  $password=$_POST['password'];   
?>

<?
//搜尋資料庫資料
$sql = 'select * from member_data';
$sql .=' WHERE id_name = '."'".$id_name."'";
$rs = mysql_query($sql)or die(mysql_error()); //sql查詢
$row = @mysql_fetch_row($rs);
?>

<?
//判斷帳號與密碼是否為空白
//以及MySQL資料庫裡是否有這個會員
//$row[1]=user_name $row[2]=id_name $row[3]=password $row[4]=mpower $row[5]=apower $row[6]=cpower $row[7]=spower 

if($id_name != null && $password != null && $row[2] == $id_name && $row[3] == $password)
{
        //將帳號寫入session，方便驗證使用者身份
		$_SESSION['member_id'] = $row[0];
        $_SESSION['id_name'] = $username;
		$_SESSION['user_name'] =$row[1];
		$_SESSION['mpower'] = $row[5];
		$_SESSION['busin_power'] = $row[11]; //業務權限
		$_SESSION['house_power'] = $row[12]; //倉儲權限
		$_SESSION['super_power'] = $row[13]; //最高權限
		$msg='登入成功';
		$location='dashboard.php';
}
else
{
        $msg='帳號密碼錯誤';
		$location='index.html';
}
?>
<?
//自動導向結果頁
if (1==1){
alert_with_location($msg,$location);
} 
?> 
