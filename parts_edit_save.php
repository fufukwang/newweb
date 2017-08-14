<?
require_once("db/mmhConf.php"); //載入檔案
?>
<?
//判斷是否有抓到 id 如果有,把抓到的id 帶入變數中
  if ($_POST['pid']!= ''){
  $pid=$_POST['pid'];
  }
  $info=$_POST['info'];
  $name=$_POST['name']; 
  $create_time = date("Y-m-d H:i:s");
?>

<?
//把接收的資料 轉成陣列
$mysql->table = 'parts_data'; //指定sql的table 有判斷大小寫
$data = array(
				'name'    => $name,
				'info'    => $info,
        'lowalert'       => _post('lowalert'),
				'create_time'    => $create_time,
				'create_user'    => $_SESSION['user_name']
				
			);
  		
?>
<?
if ($_POST['pid'] == ''){
//新增資料
$mysql->insert($data);
$parts_id = mysql_insert_id(); //抓零件的id 拿去 明細中存
  //從這邊開始抓廠商的資料
  $vendors_id = $_POST['vendors'];
  $mysql->table = 'parts_detail_data'; //廠商明細的表 明細
  for($i=0;count($vendors_id)>$i;$i++){
	$data = array(
				'pid' => $parts_id ,
				'vid'    => $vendors_id[$i]
	);
	//新增明細資料
	$mysql->insert($data);	  
  }		
$msg='新增零件成功';
$location='parts_list.php';
}
else
{
//編輯資料
$mysql->update($data,"WHERE parts_id={$pid}");
$parts_id = $pid; //抓進貨表的id 拿去 明細中存
  //從這邊開始抓產品的資料
  $vendors_id = $_POST['vendors'];
  $mysql->table = 'parts_detail_data'; //進貨明細的表 明細
  //刪除資料
  $mysql->del("WHERE pid={$pid}"); 
  for($i=0;count($vendors_id)>$i;$i++){
	$data = array(
				'pid' => $parts_id ,
				'vid'    => $vendors_id[$i]
	);
	//新增明細資料
	$mysql->insert($data);	  
  }	
$msg='編輯零件成功';
$location='parts_list.php';
} 
?>


<?
//自動導向結果頁
if (1==1){
alert_with_location($msg,$location);
} 
?> 
