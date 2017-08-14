<?
require_once("db/mmhConf.php"); //載入檔案
?>
<?
//判斷是否有抓到 id 如果有,把抓到的id 帶入變數中
  if ($_POST['nid']!= ''){
  $nid=$_POST['nid'];
  }
?>
<?
//把接收的資料 轉成陣列
$mysql->table = 'parts_needs_data'; //指定sql的table 有判斷大小寫
$data = array(
				'visible'    => 2 //2為進貨完成
			);
//編輯資料
$mysql->update($data,"WHERE needs_id={$nid}");
?>
<?
if ($_POST['nid'] != ''){
//新增資料
$mysql->insert($data);
$needs_id = $nid; //抓需求單的id 拿去 明細中存
  //從這邊開始抓零件的資料
  $parts_id = $_POST['parts_id'];
  $count = $_POST['count'];
  $mysql->table = 'parts_needs_detail_data'; //廠商明細的表 明細
  for($i=0;count($parts_id)>$i;$i++){
	$data = array(
				'father_id' => $needs_id ,
				'parts_id'    => $parts_id[$i],
				'visible'    => 1, //1為扣除需求
				'count'    => $count[$i]* -1
	);
	//扣掉需求
	$mysql->insert($data);	  
  }
  $mysql->table = 'parts_inven_data'; //廠商明細的表 明細
  for($i=0;count($parts_id)>$i;$i++){
	$data = array(
				'father_id' => $needs_id ,
				'parts_id'    => $parts_id[$i],
				'count'    => $count[$i]
	);
	//新增進貨資料
	$mysql->insert($data);	  
  }			
$msg='進貨完成';
$location='parts_needs_list.php';
}
?>
<?
//自動導向結果頁
if (1==1){
alert_with_location($msg,$location);
} 
?> 
