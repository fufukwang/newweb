<?php
require_once("db/mmhConf.php"); //載入檔案

$tag = _post('tag');
if($tag=='busupdate'){
  $info = array(
    'INotes' => _post('INotes'),
    'IName'  => _post('IName'),
    'IAddr'  => _post('IAddr'),
    'ISite'  => _post('ISite'),
    'Per'    => _post('Per')
  );
  $data = array(
    'SN'      => _post('SN'),
    'ETime'   => time(),
    'Freight' => _post('Freight'),
    'mail_id' => _post('mail_id'),
    'Info'    => serialize($info)
  );
  $mysql->table = 'Business_data';
  $BID = _post('BID');
  if(is_numeric($BID) && $BID>0){
    $mysql->update($data,"WHERE BID='$BID'");
    $txt = 'change';
  } else {
    $data['ATime']     = time();
    $data['member_id'] = $_SESSION['member_id'];
    $mysql->insert($data);
    $BID = mysql_insert_id();
    $txt = 'added';
	
	//MAIL FUNCTION 寄給最高管理人員
	require_once("_mail.php");//載入mail function
	$mysql->table = 'member_data';
	$rs_super = $mysql->select("WHERE email<>'' and super_power = 1",'email,user_name');
	while ($row_super = mysql_fetch_assoc($rs_super)) {    
	  sentmail($row_super['email'],$row_super['user_name'],'you have a new business needs','Dear '.$row_super['user_name'].' <br/>  You have a new business needs .<br/>Please log in to view management system.<br/>http://newweb.hellokiki.info');
	  //sentmail(要寄給誰的信箱,對方的名字,信件標題,信件內容);
	}
	//MAIL FUNCTION
  }

  $product_id = $_POST['ProSN'];
  $count = $_POST['Num'];
  $price = $_POST['Price'];
  $mysql->table = 'BDataDetail';
  for($i=0;count($product_id)>$i;$i++){
    $data = array(
        'BID'        => $BID ,
        'product_id' => $product_id[$i],
        'count'      => $count[$i],
        'price'      => $price[$i]
    );
    if(mysql_num_rows($mysql->select("WHERE BID='{$BID}' AND product_id='{$product_id[$i]}'"))==0){
      $mysql->insert($data);
    }
  }
  alert_with_location('Demands has been'.$txt.'!','business_list.php');
} elseif($tag=='ajax_bus_info'){  // 取得需求單資料
    $BID = _post('BID');
    $mysql->table = 'Business_data';
    $row1 = mysql_fetch_assoc($mysql->select("WHERE BID='$BID'"));
    $info = unserialize($row1['Info']);
    $mysql->table = 'BDataDetail';
    $rs = $mysql->fetch($mysql->select("LEFT JOIN product_data USING(product_id) WHERE BID='$BID'",'count,name,price,info'));
    $data = array(
      'SN'      => $row1['SN'],
      'Freight' => $row1['Freight'],
      'ATime'   => date('Y/m/d H:i:s',$row1['ATime']),
      'info'    => $info,
      'list'    => $rs
    );
    echo json_encode($data);
} elseif($tag=='ajax_ship_info'){
  $shipments_id = _post('ship_id');
  $mysql->table = 'shipments_data';
  $row1 = mysql_fetch_assoc($mysql->select("LEFT JOIN BShipLink USING(shipments_id) LEFT JOIN mail_data USING(mail_id) WHERE shipments_id='$shipments_id'"));
  $info1 = unserialize($row1['info']);
  $mysql->table = 'Business_data';
  $row2 = mysql_fetch_assoc($mysql->select("LEFT JOIN member_data USING(member_id) WHERE BID='{$row1['BID']}'"));
  $info2 = unserialize($row2['Info']);
  $mysql->table = 'shipments_detail_data';
  $rs = $mysql->fetch($mysql->select("LEFT JOIN product_data USING(product_id) WHERE group_id='$shipments_id'","count,info,name,price,(SELECT COUNT(Quantity) FROM(PackDetail) WHERE PackDetail.product_id=shipments_detail_data.product_id AND ship_id='$shipments_id') AS pack,product_data.product_id"));
  $data = array(
    'info' => array(
      'd2_1' => date('Y/m/d H:i:s',$row2['ATime']),
      'd2_2' => $row2['SN'],
      'd2_3' => $row2['user_name'],
      'd2_4' => $info1['OutAddr'],
      'd2_5' => $info2['IName'],
      'd2_6' => $row1['create_time'],
      'd2_7' => $row1['name'],
      'd2_8' => $row1['number'],
      'd2_9' => $info1['info'],
      'd2_Par'  => $info2['Per'],
      'd2_Addr' => $info2['IAddr'],
      'Invoice' => $row1['Invoice']
    ),
    'list' => $rs
  );
  echo json_encode($data);
} elseif($tag=='ship_list'){
  $BID = _post('BID');
  $mysql->table = 'BDataDetail';
  $data = $mysql->fetch($mysql->select("LEFT JOIN product_data USING(product_id) WHERE BID='$BID'",'count,name,info,product_data.product_id,(SELECT SUM(count) FROM(complete_detail_data) WHERE complete_detail_data.product_id=BDataDetail.product_id ) AS Lim'));
  $mysql->table = 'BShipLink';
  $rs = $mysql->select("WHERE BID='{$BID}'",'shipments_id');
  $ship_id = '';
  while($row = mysql_fetch_assoc($rs)){
    $ship_id .= $ship_id=='' ? $row['shipments_id'] : ','.$row['shipments_id'];
  }
  if($ship_id!=''){
    $ship_id = ' AND group_id IN ('.$ship_id.')';
  } else {
    $ship_id = ' AND group_id<0';
  }
  $mysql->table = 'shipments_detail_data';
  for($i=0;$i<count($data);$i++){
    // 存貨 = 產品 - 出貨 + 退貨
    $out = mysql_result($mysql->select("LEFT JOIN shipments_data ON shipments_detail_data.group_id=shipments_data.shipments_id WHERE product_id='{$data[$i]['product_id']}' AND cancel=0".$ship_id,'SUM(count) AS C'),0,'C');
    $re  = mysql_result($mysql->select("LEFT JOIN shipments_data ON shipments_detail_data.group_id=shipments_data.shipments_id WHERE product_id='{$data[$i]['product_id']}' AND cancel>0".$ship_id,'SUM(count) AS C'),0,'C');
    $data[$i]['save'] = $data[$i]['Lim'] ? $data[$i]['Lim'] : 0;
    $data[$i]['out']  = $data[$i]['count'] - $out - $re;
    $data[$i]['Lim'] = $data[$i]['count'] - $out + $re;
  }
  $mysql->table = 'Business_data';
  $bdata = mysql_fetch_assoc($mysql->select("WHERE BID='$BID'",'Freight,Info'));
  $bdata['Info'] = unserialize($bdata['Info']);
  $data = array(
    'Invoice' => $bdata['Freight'],
    'OutAddr' => $bdata['Info']['ISite'],
    'IName'   => $bdata['Info']['IName'],
    'IAddr'   => $bdata['Info']['IAddr'],
    'mail_id' => $bdata['mail_id'],
    'SN'      => $bdata['SN'],
    'data'    => $data
  );
  echo json_encode($data);
} elseif($tag=='Bus_Checked'){
  $mysql->table = 'Business_data';
  $BID = _post('BID');
  $mysql->update(array('Checked'=>1),"WHERE BID='{$BID}'");
  $row1 = mysql_fetch_assoc($mysql->select("WHERE BID='{$BID}'","SN"));
  //MAIL FUNCTION 
  //寄給 倉儲人員 
  require_once("_mail.php");//載入mail function
  $mysql->table = 'member_data';
  $rs_house = $mysql->select("WHERE email<>'' and house_power = 1 ",'email,user_name');
  while ($row_house = mysql_fetch_assoc($rs_house)) {
    sentmail($row_house['email'],$row_house['user_name'],'you have a new business needs','Dear '.$row_house['user_name'].' <br/> You have a new business needs<br/>Please log in to view management system.<br/> .http://newweb.hellokiki.info');
    //sentmail(要寄給誰的信箱,對方的名字,信件標題,信件內容);
  }
  
  //寄給 業務人員
  $rs_busin = $mysql->select("WHERE email<>'' and busin_power = 1",'email,user_name');
  while ($row_busin = mysql_fetch_assoc($rs_busin)) {
    sentmail($row_busin['email'],$row_busin['user_name'],'your business needs  '.$row1['SN'].'  has been confirm','Dear '.$row_busin['user_name'].'<br/> Your business needs'.$row1['SN'].'has been confirm.<br/>Please log in to view management system.<br/> http://newweb.hellokiki.info');
    //sentmail(要寄給誰的信箱,對方的名字,信件標題,信件內容);
  }
  //MAIL FUNCTION

  //sentmail('kenandytw@gmail.com','Randy','Demand notice','您的需求已通過,請至後台查看.http://newweb.hellokiki.info');
  //sentmail(要寄給誰的信箱,對方的名字,信件標題,信件內容);
} elseif($tag=='Bus_Del'){
  $mysql->table = 'Business_data';
  $BID = _post('BID');
  $mysql->del("WHERE BID='{$BID}'");
/**********************************************************************************************************************
********     出貨 *****************************************************************************************************
**********************************************************************************************************************/
} elseif($tag=='ship_new'){
  $BID = _post('BID');
  $mysql->table = 'Business_data';
  $bdata = mysql_fetch_assoc($mysql->select("WHERE BID='$BID'",'Info'));
  $bdata['Info'] = unserialize($bdata['Info']);
  $bdata['Info']['ISite'] = _post('OutAddr');
  $Info = serialize($bdata['Info']);
  $mysql->update(array('Info'=>$Info),"WHERE BID='{$BID}'");

  $info = array(
    'Carrier' => _post('Carrier'),
    'Per'     => _post('Per'),
    'info'    => _post('info'),
    'OutAddr' => _post('OutAddr')
  );
  $data = array(
    'member_id'   => $_SESSION['member_id'],
    'Invoice'     => _post('Invoice'),
    'number'      => _post('number'),
    'info'        => serialize($info),
    'create_time' => time(),
    'mail_id'     => _post('mail_id'),
    'cancel'      => 0
  );
  $mysql->table = 'shipments_data';
  $mysql->insert($data);
  $shipment_id = mysql_insert_id();

  $data = array(
    'BID'          => $BID,
    'shipments_id' => $shipment_id,
    'LTime'        => time()
  );
  $mysql->table = 'BShipLink';
  $mysql->insert($data);

  $product_id = $_POST['ProID'];
  $count      = $_POST['Num'];
  $price      = $_POST['price'];
  $mysql->table = 'shipments_detail_data';
  for($i=0;count($product_id)>$i;$i++){
    $data = array(
      'group_id'   => $shipment_id,
      'product_id' => $product_id[$i],
      'count'      => $count[$i],
      'price'      => $price[$i]
    );
    $mysql->insert($data);
  }

  // 計算是否到達結案數量結案
  $mysql->table = 'BShipLink';
  $rs = $mysql->select("WHERE BID='{$BID}'",'shipments_id');
  $ship_id = '';
  while($row = mysql_fetch_assoc($rs)){
    $ship_id .= $ship_id=='' ? $row['shipments_id'] : ','.$row['shipments_id'];
  }
  $mysql->table = 'BDataDetail';
  $need = mysql_fetch_assoc($mysql->select("WHERE BID='{$BID}'","SUM(count) AS C"));
  $mysql->table = 'shipments_detail_data';
  $already = 0;
  if($ship_id!=''){
    $out  = mysql_fetch_assoc($mysql->select("LEFT JOIN shipments_data ON shipments_data.shipments_id=shipments_detail_data.group_id WHERE group_id IN ({$ship_id}) AND cancel=0","SUM(count) AS C"));
    $cancel  = mysql_fetch_assoc($mysql->select("LEFT JOIN shipments_data ON shipments_data.shipments_id=shipments_detail_data.group_id WHERE group_id IN ({$ship_id}) AND cancel>0","SUM(count) AS C"));
    $already = $out['C'] - $cancel['C'];
  }
  if($need['C']-$already<=0){
    $mysql->table = 'Business_data';
    $mysql->update(array('End'=>1),"WHERE BID='{$BID}'");
    $mysql->table = 'BDataDetail';
    $detail = $mysql->select("WHERE BID='{$BID}'");
    $mysql->table = 'complete_detail_data';
    while($drow = mysql_fetch_assoc($detail)){
      $cdata = array(
        'product_id'  => $drow['product_id'],
        'count'       => $drow['count']*-1,
        'create_time' => date('Y-m-d H:i:s'),
        'BID'         => $drow['BID']
      );
      $mysql->insert($cdata);
    }
    //MAIL FUNCTION 確認結案 寄給最高管理人員
    require_once("_mail.php");
    $mysql->table = 'member_data';
    $mrs = $mysql->select("WHERE email<>'' and super_power = 1",'email,user_name');
    while($mrow = mysql_fetch_assoc($mrs)){	   
       sentmail($mrow['email'],$mrow['user_name'],'Ship completed','Dear '.$mrow['user_name'].' <br/> Your Packing No.'._post('number').'has been completed');
    }
  }	

  alert_with_location('出貨資料已新增!','shipments_list.php');
} elseif($tag=='ship_c_list'){
  $shipments_id = _post('shipments_id');
  $mysql->table = 'shipments_detail_data';
  $data = $mysql->fetch($mysql->select("LEFT JOIN product_data USING(product_id) WHERE group_id='$shipments_id'",'count,name,info,product_data.product_id'));
  for($i=0;$i<count($data);$i++){
    // 出貨 + 退貨
    $out = mysql_result($mysql->select("LEFT JOIN shipments_data ON shipments_detail_data.group_id=shipments_data.shipments_id WHERE product_id='{$data[$i]['product_id']}' AND cancel=0",'SUM(count) AS C'),0,'C');
    $re  = mysql_result($mysql->select("LEFT JOIN shipments_data ON shipments_detail_data.group_id=shipments_data.shipments_id WHERE product_id='{$data[$i]['product_id']}' AND cancel>0",'SUM(count) AS C'),0,'C');
    $data[$i]['Lim'] = $out - $re;
  }
  echo json_encode($data);
} elseif($tag=='ship_canel'){ // 退貨
  $info = array(
    'info'  => _post('info')
  );
  $data = array(
    'member_id'   => $_SESSION['member_id'],
    'Invoice'     => _post('Invoice'),
    'number'      => _post('number'),
    'info'        => serialize($info),
    'create_time' => time(),
    'cancel'      => _post('shipments_id')
  );
  $mysql->table = 'shipments_data';
  $mysql->insert($data);
  $shipments_id = mysql_insert_id();

  $data = array(
    'BID'          => _post('BID'),
    'shipments_id' => $shipments_id,
    'LTime'        => time()
  );
  $mysql->table = 'BShipLink';
  $mysql->insert($data);

  // 計算數量
  $mysql->table = 'Business_data';
  if(mysql_num_rows($mysql->select("WHERE BID='$BID' AND End=1"))){ // 如果以結案 就取消結案
    $mysql->update(array('End'=>0),"WHERE BID='{$BID}'");
    $mysql->table = 'BDataDetail';
    $detail = $mysql->select("WHERE BID='{$BID}'");
    $mysql->table = 'complete_detail_data';
    while($drow = mysql_fetch_assoc($detail)){
      $cdata = array(
        'product_id'  => $drow['product_id'],
        'count'       => $drow['count'],
        'create_time' => date('Y-m-d H:i:s'),
        'BID'         => $drow['BID']
      );
      $mysql->insert($cdata);
    }
  }

  $product_id = $_POST['ProID'];
  $count      = $_POST['Num'];
  $mysql->table = 'shipments_detail_data';
  for($i=0;count($product_id)>$i;$i++){
    $data = array(
      'group_id'   => $shipment_id,
      'product_id' => $product_id[$i],
      'count'      => $count[$i]
    );
    $mysql->insert($data);
  }
  alert_with_location('退貨資料已新增!','shipments_list.php');

/**********************************************************************************************************************
********     零件進貨 驗證 ********************************************************************************************
**********************************************************************************************************************/
} elseif($tag=='parts_num_validate'){
  $parts_id = $_POST['parts_id'];
  $num      = $_POST['num'];
  $data = array('success'=>'Y');
  $mysql->table = 'parts_inven_data';
  for($i=0;$i<count($parts_id);$i++){
    $max = mysql_result($mysql->select("WHERE parts_id='{$parts_id[$i]}'",'SUM(count) AS C'),0,'C');
    if($num[$i]>$max){
      $data = array('success'=>'N');
    }
  }
  $data['cutid']  = implode(",",$parts_id);
  $data['cutnum'] = implode(",",$num);
  echo json_encode($data);
} elseif($tag=='complete_update'){
  $data = array(
    'number'      => _post('number'),
    'info'        => _post('info'),
    'create_user' => $_SESSION['user_name'],
    'create_time' => _post('over_date'),
    'ATime'       => time()
  );
  $mysql->table = 'complete_data';
  $mysql->insert($data);
  $complete_id = mysql_insert_id();

  $product_id = $_POST['product_id'];
  $count = $_POST['count'];
  $mysql->table = 'complete_detail_data';
  for($i=0;count($product_id)>$i;$i++){
    $data = array(
        'group_id'    => $complete_id,
        'product_id'  => $product_id[$i],
        'count'       => $count[$i],
        'create_time' => date('Y-m-d H:i:s')
    );
    if(mysql_num_rows($mysql->select("WHERE group_id='{$complete_id}' AND product_id='{$product_id[$i]}'"))==0 && $count[$i]>0){
      $mysql->insert($data);
    }
  }
  $json['parts_id'] = split(',',_post('cutid'));
  $json['num']      = split(',',_post('cutnum'));
  $mysql->table = 'parts_inven_data';
  for($i=0;$i<count($json['parts_id']);$i++){
    $zo = array(
      'parts_id'  => $json['parts_id'][$i],
      'count'     => $json['num'][$i]*-1,
      'father_id' => $complete_id
    );
    $mysql->insert($zo);
  }
  alert_with_location('成品資料已新增!','complete_list.php');
} elseif($tag=='complete_c_list'){
  $complete_id = _post('complete_id');
  $mysql->table = 'complete_detail_data';
  $data = $mysql->fetch($mysql->select("LEFT JOIN product_data USING(product_id) WHERE group_id='$complete_id'",'count,name,product_data.product_id'));
  echo json_encode($data);
} elseif($tag=='complete_cancel'){
  $data = array(
    'number'      => _post('complete_id'),
    'info'        => _post('info'),
    'create_user' => $_SESSION['user_name'],
    'create_time' => _post('over_date'),
    'ATime'       => time(),
    'cancel'      => 1
  );
  $mysql->table = 'complete_data';
  $mysql->insert($data);
  $complete_id = mysql_insert_id();

  $product_id = $_POST['ProID'];
  $count = $_POST['Num'];
  $mysql->table = 'complete_detail_data';
  for($i=0;count($product_id)>$i;$i++){
    $data = array(
        'group_id'    => $complete_id,
        'product_id'  => $product_id[$i],
        'count'       => $count[$i]*-1,
        'create_time' => date('Y-m-d H:i:s')
    );
    if(mysql_num_rows($mysql->select("WHERE group_id='{$complete_id}' AND product_id='{$product_id[$i]}'"))==0 && $count[$i]>0){
      $mysql->insert($data);
    }
  }
  alert_with_location('以取消成品!','complete_list.php');
/**********************************************************************************************************************
********     包裝 ********************************************************************************************
**********************************************************************************************************************/
} elseif($tag == 'packing_update'){
  $ship_id = _post('shipments_id');
  $Packingdata = array(
    'shipments_id' => $ship_id,
    'member_id'    => $_SESSION['member_id'],
    'PackTime'     => time()
  );
  $mysql->table = 'Packing';
  $PID = _post('PID');
  if($PID){
    $txt = 'change';
  } else {
    $mysql->insert($Packingdata);
    $PID = mysql_insert_id();
    $txt = 'added';
  }

  $PNOarr = $_POST['PNO'];
  $PBIDa  = $_POST['PBID'];
  for($i=0;count($PNOarr)>$i;$i++){
    $PBdata = array(
      'PID' => $PID ,
      'PNO' => $PNOarr[$i]
    );
    $mysql->table = 'PackBox';
    if(is_numeric($PBIDa[$i]) && $PBIDa[$i]>0){
      $mysql->update($PBdata,"WHERE PBID='{$PBIDa[$i]}'");
      $PBID = $PBIDa[$i];
    } else {
      $mysql->insert($PBdata);
      $PBID = mysql_insert_id();
    }

    $num = $i+1;
    $Qarr = $_POST['Quantity_'.$num];
    $Narr = $_POST['NW_'.$num];
    $Garr = $_POST['GW_'.$num];
    $Parr = $_POST['product_id_'.$num];
    $Darr = $_POST['PDID_'.$num];
    for($j=0;count($Parr)>$j;$j++){
      $PDdata = array(
        'PID'        => $PID,
        'PBID'       => $PBID,
        'Quantity'   => $Qarr[$j],
        'NW'         => $Narr[$j],
        'GW'         => $Garr[$j],
        'product_id' => $Parr[$j]
      );
      $mysql->table = 'PackDetail';
      if(is_numeric($Darr[$j]) && $Darr[$j]>0){
        $mysql->update($PDdata,"WHERE PDID='{$Darr[$j]}'");
      } else {
        $PDdata['ship_id'] = $ship_id;
        $mysql->insert($PDdata);
      }
    }
  }
  alert_with_location('Packing has been '.$txt,'packing_list.php');
} elseif($tag == 'packing_sent_mail'){
  $PID = _post('PID');
  //MAIL FUNCTION
  require_once("_mail.php");//載入mail function
  $mysql->table = 'shipments_data';
  $rs_super = $mysql->select("LEFT JOIN mail_data USING(mail_id)",'mail,name');
  while ($row_super = mysql_fetch_assoc($rs_super)) {    
    sentmail($row_super['mail'],$row_super['name'],'Sacoa Shipment Notification','Dear '.$row_super['name'].' <br/>  You have a ship Demands a detailed look at the following links:<br /><a href="http://newweb.hellokiki.info/packing_print.php?PID='.$PID.'">http://newweb.hellokiki.info/packing_print.php</a>');
  }
  //MAIL FUNCTION
  // write mail sent
  $mysql->table = 'Packing';
  $time = time();
  $mysql->update(array('MailTime'=>$time),"WHERE PID='$PID'");
  // write mail sent
  echo json_encode(array('success'=>'Y','mt'=>date('Y-m-d H:i:s',$time)));
} elseif($tag == 'Get_Packing_AWB'){
  $PID = _post('PID');
  $mysql->table = 'Packing';
  $data = mysql_fetch_assoc($mysql->select("WHERE PID='$PID'","AWB"));
  echo json_encode($data);
} elseif ($tag == 'Write_Packing_AWB') {
  $PID = _post('PID');
  $AWB = _post('AWB');
  $mysql->table = 'Packing';
  $mysql->update(array('AWB'=>$AWB),"WHERE PID='$PID'");
} elseif($tag == 'Get_Inquiry_Detail'){
  $IID = _post('IID');
  $mysql->table = 'Inquiry';
  $data = mysql_fetch_assoc($mysql->select("LEFT JOIN mail_data USING(mail_id) WHERE IID='$IID'","Inq,ToW,Weight,Mon,FROM_UNIXTIME(ATime,'%Y/%m/%d %H:%i') AS ATime,name,Inquiry.mail_id"));
  echo json_encode($data);
} elseif($tag == 'inquiry_sent_mail'){
  $IID = _post('IID');
  //MAIL FUNCTION
  require_once("_mail.php");//載入mail function
  $mysql->table = 'Inquiry';
  $rs_super = $mysql->select("LEFT JOIN mail_data USING(mail_id)",'mail,name,ToW,Weight');
  while ($row_super = mysql_fetch_assoc($rs_super)) {    
    sentmail($row_super['mail'],$row_super['name'],'Sacoa Shipment Notification','Dear '.$row_super['user_name'].' <br/>  運送地點:'.$row_super['ToW'].'<br />貨物重量:'.$row_super['Weight']);
  }
  //MAIL FUNCTION
  // write mail sent
  $mysql->table = 'Inquiry';
  $time = time();
  $mysql->update(array('MailTime'=>$time),"WHERE IID='$IID'");
  // write mail sent
  echo json_encode(array('success'=>'Y','mt'=>date('Y-m-d H:i:s',$time)));
} elseif($tag == 'Inquiry_Step_1'){  // 業務填表
  $IID  = _post('IID');
  $data = array(
    'Inq'     => _post('Inq'),
    'mail_id' => _post('mail_id'),
    'ToW'     => _post('ToW')
  );
  $mysql->table = 'Inquiry';
  if(is_numeric($IID) && $IID>0){
    $mysql->update($data,"WHERE IID='$IID'");
    $mes = mysql_fetch_assoc($mysql->select("LEFT JOIN mail_data USING(mail_id) WHERE IID='$IID'","ToW,name"));
  } else {
    $data['ATime'] = time();
    $data['MeM1']  = $_SESSION['member_id'];
    $mysql->insert($data);
    $mes = array('success'=>'insert');
  }
  echo json_encode($mes);
} elseif($tag == 'Inquiry_Step_2'){  // 包裝填表
  $IID    = _post('IID');
  $data = array(
    'Weight' => _post('Weight'),
    'MeM2'   => $_SESSION['member_id']
  );
  $mysql->table = 'Inquiry';
  $mysql->update($data,"WHERE IID='$IID'");
  echo json_encode(array('success'=>'yes'));
} elseif($tag == 'Inquiry_Step_3'){  // 管理者填表
  $IID    = _post('IID');
  $data = array(
    'Mon'  => _post('Mon'),
    'MeM3' => $_SESSION['member_id']
  );
  $mysql->table = 'Inquiry';
  $mysql->update($data,"WHERE IID='$IID'");
  echo json_encode(array('success'=>'yes'));
} elseif($tag == 'Get_Inquiry_Mem'){
  $IID    = _post('IID');
  $mysql->table = 'Inquiry';
  $data = mysql_fetch_assoc($mysql->select("WHERE IID='$IID'","(SELECT user_name FROM(member_data) WHERE member_data.member_id=Inquiry.MeM1) AS Mem1,(SELECT user_name FROM(member_data) WHERE member_data.member_id=Inquiry.MeM2) AS Mem2,(SELECT user_name FROM(member_data) WHERE member_data.member_id=Inquiry.MeM3) AS Mem3"));
  echo json_encode($data);
}

?>