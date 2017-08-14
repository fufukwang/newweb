<?
require_once("db/mmhConf.php"); //載入檔案
?>
<?
//判斷是否有抓到 id 如果有,把抓到的id 帶入變數中
  if ($_POST['tag']!= ''){
  $tag=$_POST['tag'];
  }
?>
<? if ($tag == 1){?> <!--進貨-->
<?
  $info=$_POST['info'];
  $create_time = date("Y-m-d H:i:s");
  $maxorder=date("Y-m-d H:i:s");
  $maxorder = str_replace(":", "", $maxorder);
  $maxorder = str_replace(" ", "", $maxorder);
  $maxorder = str_replace("-", "", $maxorder);
  $mysql->table = 'purchase_data';//Table名稱 進貨的表 只存id
//  $maxorder = $mysql->field_max('number'); //找欄位最大值
//  if($maxorder!=-1){ // 最新的一筆
//	  $maxorder = date("Ymd0001");
//  } else { // 已有最大值資料
//	  $maxorder = (int)$maxorder + 1;
//  }
  $data = array(
  	'number'=>a.$maxorder,
	'info'=>$info,
	'create_time'    => $create_time
  );
  //新增進貨單資料
  $mysql->insert($data);
  $purchase_id = mysql_insert_id(); //抓進貨表的id 拿去 明細中存
?>
<?   
  //從這邊開始抓產品的資料
  $product_id = $_POST['ProSN'];
  $count = $_POST['Num'];
  $mysql->table = 'purchase_detail_data'; //進貨明細的表 明細
  
  for($i=0;count($product_id)>$i;$i++){
	$data = array(
				'group_id' => $purchase_id ,
				'product_id'    => $product_id[$i], //陣列儲存的範例
				'create_time'    => $create_time,
				'count' => $count[$i]
	);
	//新增明細資料
	$mysql->insert($data);
	
	  
  }
  $location='addition_list.php';
  $msg='進貨成功';
?>

<?
//自動導向結果頁
if (1==1){
//$url = "msg.php?nid=".$nid;
alert_with_location($msg,$location);
} 
?> 
<? }?>
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<? if ($tag == 2){?> <!--成品-->
<?
  $info=$_POST['info'];
  $create_time = date("Y-m-d H:i:s");
  $maxorder=date("Y-m-d H:i:s");
  $maxorder = str_replace(":", "", $maxorder);
  $maxorder = str_replace(" ", "", $maxorder);
  $maxorder = str_replace("-", "", $maxorder);
  $mysql->table = 'complete_data';//Table名稱 進貨的表 只存id
//  $maxorder = $mysql->field_max('number'); //找欄位最大值
//  if($maxorder!=-1){ // 最新的一筆
//	  $maxorder = date("Ymd0001");
//  } else { // 已有最大值資料
//	  $maxorder = (int)$maxorder + 1;
//  }
  $data = array(
  	'number'=>c.$maxorder,
	'info'=>$info,
	'create_time'    => $create_time
  );
  //新增進貨單資料
  $mysql->insert($data);
  $complete_id = mysql_insert_id(); //抓進貨表的id 拿去 明細中存
?>
<?   
  //從這邊開始抓產品的資料
  $product_id = $_POST['ProSN'];
  $count = $_POST['Num'];
  $mysql->table = 'complete_detail_data'; //進貨明細的表 明細
  
  for($i=0;count($product_id)>$i;$i++){
	$data = array(
				'group_id' => $complete_id ,
				'product_id'    => $product_id[$i], //陣列儲存的範例
				'create_time'    => $create_time,
				'count' => $count[$i]
	);
	//新增明細資料
	$mysql->insert($data);
	
	  
  }
  $location='complete_list.php';
  $msg='成品建立成功';
?>

<?
//自動導向結果頁
if (1==1){
//$url = "msg.php?nid=".$nid;
alert_with_location($msg,$location);
} 
?> 
<? }?>
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<? if ($tag == 3){?> <!--出貨-->
<?
  $info=$_POST['info'];
  $client=$_POST['client'];
  $location=$_POST['location'];
  $create_time = date("Y-m-d H:i:s");
  $maxorder=date("Y-m-d H:i:s");
  $maxorder = str_replace(":", "", $maxorder);
  $maxorder = str_replace(" ", "", $maxorder);
  $maxorder = str_replace("-", "", $maxorder);
  $mysql->table = 'shipments_data';//Table名稱 進貨的表 只存id
//  $maxorder = $mysql->field_max('number'); //找欄位最大值
//  if($maxorder!=-1){ // 最新的一筆
//	  $maxorder = date("Ymd0001");
//  } else { // 已有最大值資料
//	  $maxorder = (int)$maxorder + 1;
//  }
  $data = array(
  	'number'=>s.$maxorder,
	'info'=>$info,
	'client'=>$client,
	'location'=>$location,
	'create_time'    => $create_time
  );
  //新增進貨單資料
  $mysql->insert($data);
  $shipments_id = mysql_insert_id(); //抓進貨表的id 拿去 明細中存
?>
<?   
  //從這邊開始抓產品的資料
  $product_id = $_POST['ProSN'];
  $count = $_POST['Num'];
  $mysql->table = 'shipments_detail_data'; //進貨明細的表 明細
  
  for($i=0;count($product_id)>$i;$i++){
	$data = array(
				'group_id' => $shipments_id ,
				'product_id'    => $product_id[$i], //陣列儲存的範例
				'create_time'    => $create_time,
				'count' => $count[$i]
	);
	//新增明細資料
	$mysql->insert($data);
	
	  
  }
  $location='shipments_list.php';
  $msg='出貨成功';
?>

<?
//自動導向結果頁
if (1==1){
//$url = "msg.php?nid=".$nid;
alert_with_location($msg,$location);
} 
?> 
<? }?>
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<? if ($tag == 4){?> <!--退貨-->
<?
  $info=$_POST['info'];
  $create_time = date("Y-m-d H:i:s");
  $maxorder=date("Y-m-d H:i:s");
  $maxorder = str_replace(":", "", $maxorder);
  $maxorder = str_replace(" ", "", $maxorder);
  $maxorder = str_replace("-", "", $maxorder);
  $mysql->table = 'purchase_data';//Table名稱 進貨的表 只存id
//  $maxorder = $mysql->field_max('number'); //找欄位最大值
//  if($maxorder!=-1){ // 最新的一筆
//	  $maxorder = date("Ymd0001");
//  } else { // 已有最大值資料
//	  $maxorder = (int)$maxorder + 1;
//  }
  $data = array(
  	'number'=>a.$maxorder,
	'info'=>$info,
	'cancel'=> 1,
	'create_time'    => $create_time
  );
  //新增進貨單資料
  $mysql->insert($data);
  $purchase_id = mysql_insert_id(); //抓進貨表的id 拿去 明細中存
?>
<?   
  //從這邊開始抓產品的資料
  $product_id = $_POST['ProSN'];
  $count = $_POST['Num'];
  $mysql->table = 'purchase_detail_data'; //進貨明細的表 明細
  
  for($i=0;count($product_id)>$i;$i++){
	$data = array(
				'group_id' => $purchase_id ,
				'product_id'    => $product_id[$i], //陣列儲存的範例
				'create_time'    => $create_time,
				'count' => $count[$i]* -1
	);
	//新增明細資料
	$mysql->insert($data);
	
	  
  }
  $location='addition_list.php';
  $msg='退貨成功';
?>

<?
//自動導向結果頁
if (1==1){
//$url = "msg.php?nid=".$nid;
alert_with_location($msg,$location);
} 
?> 
<? }?>
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<? if ($tag == 5){?> <!--刪除成品-->
<?
  $info=$_POST['info'];
  $create_time = date("Y-m-d H:i:s");
  $maxorder=date("Y-m-d H:i:s");
  $maxorder = str_replace(":", "", $maxorder);
  $maxorder = str_replace(" ", "", $maxorder);
  $maxorder = str_replace("-", "", $maxorder);
  $mysql->table = 'complete_data';//Table名稱 進貨的表 只存id
//  $maxorder = $mysql->field_max('number'); //找欄位最大值
//  if($maxorder!=-1){ // 最新的一筆
//	  $maxorder = date("Ymd0001");
//  } else { // 已有最大值資料
//	  $maxorder = (int)$maxorder + 1;
//  }
  $data = array(
  	'number'=>c.$maxorder,
	'info'=>$info,
	'cancel'=> 1,
	'create_time'    => $create_time
  );
  //新增進貨單資料
  $mysql->insert($data);
  $complete_id = mysql_insert_id(); //抓進貨表的id 拿去 明細中存
?>
<?   
  //從這邊開始抓產品的資料
  $product_id = $_POST['ProSN'];
  $count = $_POST['Num'];
  $mysql->table = 'complete_detail_data'; //進貨明細的表 明細
  
  for($i=0;count($product_id)>$i;$i++){
	$data = array(
				'group_id' => $complete_id ,
				'product_id'    => $product_id[$i], //陣列儲存的範例
				'create_time'    => $create_time,
				'count' => $count[$i]* -1
	);
	//新增明細資料
	$mysql->insert($data);
	
	  
  }
  $location='complete_list.php';
  $msg='成品刪除成功';
?>

<?
//自動導向結果頁
if (1==1){
//$url = "msg.php?nid=".$nid;
alert_with_location($msg,$location);
} 
?> 
<? }?>
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<!--分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線分隔線-->
<? if ($tag == 6){?> <!--商品退貨-->
<?
  $info=$_POST['info'];
  $client=$_POST['client'];
  $location=$_POST['location'];
  $create_time = date("Y-m-d H:i:s");
  $maxorder=date("Y-m-d H:i:s");
  $maxorder = str_replace(":", "", $maxorder);
  $maxorder = str_replace(" ", "", $maxorder);
  $maxorder = str_replace("-", "", $maxorder);
  $mysql->table = 'shipments_data';//Table名稱 進貨的表 只存id
//  $maxorder = $mysql->field_max('number'); //找欄位最大值
//  if($maxorder!=-1){ // 最新的一筆
//	  $maxorder = date("Ymd0001");
//  } else { // 已有最大值資料
//	  $maxorder = (int)$maxorder + 1;
//  }
  $data = array(
  	'number'=>s.$maxorder,
	'info'=>$info,
	'client'=>$client,
	'location'=>$location,
	'cancel'=> 1,
	'create_time'    => $create_time
  );
  //新增進貨單資料
  $mysql->insert($data);
  $shipments_id = mysql_insert_id(); //抓進貨表的id 拿去 明細中存
?>
<?   
  //從這邊開始抓產品的資料
  $product_id = $_POST['ProSN'];
  $count = $_POST['Num'];
  $mysql->table = 'shipments_detail_data'; //進貨明細的表 明細
  
  for($i=0;count($product_id)>$i;$i++){
	$data = array(
				'group_id' => $shipments_id ,
				'product_id'    => $product_id[$i], //陣列儲存的範例
				'create_time'    => $create_time,
				'count' => $count[$i]* -1
	);
	//新增明細資料
	$mysql->insert($data);
	
	  
  }
  $location='shipments_list.php';
  $msg='退貨成功';
?>

<?
//自動導向結果頁
if (1==1){
//$url = "msg.php?nid=".$nid;
alert_with_location($msg,$location);
} 
?> 
<? }?>