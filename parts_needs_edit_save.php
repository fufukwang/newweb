<?
require_once("db/mmhConf.php"); //載入檔案
?>
<?
//判斷是否有抓到 id 如果有,把抓到的id 帶入變數中
  if ($_POST['nid']!= ''){
  $nid=$_POST['nid'];
  }
  $info=$_POST['info'];
  $over_date=$_POST['over_date'];
  //$name=$_POST['name']; 
  $create_time = date("Y-m-d H:i:s");
  $maxorder=date("Y-m-d H:i:s");
  $maxorder = str_replace(":", "", $maxorder);
  $maxorder = str_replace(" ", "", $maxorder);
  $maxorder = str_replace("-", "", $maxorder);
?>

<?
if ($_POST['nid'] == ''){
//把接收的資料 轉成陣列
$mysql->table = 'parts_needs_data'; //指定sql的table 有判斷大小寫
$data = array(
				'number'    => _post('number'),
				'info'    => $info,
				'create_time'    => $create_time,
				'over_date'    => $over_date,
        'vendors_id'   => _post('vendors_id'),
				'create_user'    => $_SESSION['user_name']				
			);
}
else
{
$mysql->table = 'parts_needs_data'; //指定sql的table 有判斷大小寫
$data = array(
				'info'    => $info,
				'create_time'    => $create_time,
				'over_date'    => $over_date,
        'vendors_id'   => _post('vendors_id'),
				'create_user'    => $_SESSION['user_name']				
			);	
}	  		
?>
<?
if ($_POST['nid'] == ''){
//新增資料
$mysql->insert($data);
$needs_id = mysql_insert_id(); //抓需求單的id 拿去 明細中存
  //從這邊開始抓零件的資料
  $parts_id = $_POST['parts_id'];
  $count = $_POST['count'];
  $mysql->table = 'parts_needs_detail_data'; //廠商明細的表 明細
  for($i=0;count($parts_id)>$i;$i++){
	$data = array(
				'father_id' => $needs_id ,
				'parts_id'    => $parts_id[$i],
				'count'    => $count[$i]
	);
	//新增明細資料
	$mysql->insert($data);	  
  }		
$msg='零件進貨成功';
require_once("_mail.php");//載入mail function
$mysql->table = 'member_data';
$rs = $mysql->select("WHERE email<>''",'email,user_name');
while ($row = mysql_fetch_assoc($rs)) {
  sentmail($row['email'],$row['user_name'],'testing','進貨了快去看');
  //sentmail(要寄給誰的信箱,對方的名字,信件標題,信件內容);
}
$location='parts_needs_list.php';
}
else
{
//編輯資料
$mysql->update($data,"WHERE needs_id={$nid}");
  $needs_id = $nid; //抓進貨表的id 拿去 明細中存
  //從這邊開始抓產品的資料
  $parts_id = $_POST['parts_id'];
  $count = $_POST['count'];
  $mysql->table = 'parts_needs_detail_data'; //進貨明細的表 明細
  //刪除資料
  $mysql->del("WHERE father_id={$nid}"); 
  for($i=0;count($parts_id)>$i;$i++){
	$data = array(
				'father_id' => $needs_id ,
				'parts_id'    => $parts_id[$i],
				'count'    => $count[$i]
	);
	//新增明細資料
	$mysql->insert($data);	  
  }	
$msg='編輯零件進貨成功';
$location='parts_needs_list.php';
} 
?>
<?
//自動導向結果頁
if (1==1){
alert_with_location($msg,$location);
} 
?> 
 