<?
require_once("db/mmhConf.php"); //載入檔案
$promes = '';
// 成品庫存
$mysql->table = 'product_data';
$rsc = $mysql->select("WHERE (SELECT SUM(count) FROM(complete_detail_data) WHERE complete_detail_data.product_id=product_data.product_id)<lowalert",'name,(SELECT SUM(count) FROM(complete_detail_data) WHERE complete_detail_data.product_id=product_data.product_id) AS sumc,product_id,lowalert');
while ($row = mysql_fetch_assoc($rsc)) {
    if($promes==''){
        $promes = '<br />成品庫存不足通知:<br />';
    }
    $promes .= $row['name'].' 現存量 '.$row['sumc'];
}

$partmes = '';
// 零件庫存
$mysql->table = 'parts_data';
$rso = $mysql->select("WHERE (SELECT SUM(count) FROM(parts_inven_data) WHERE parts_inven_data.parts_id=parts_data.parts_id)<lowalert",'name,(SELECT SUM(count) FROM(parts_inven_data) WHERE parts_inven_data.parts_id=parts_data.parts_id) AS sumc,parts_id,lowalert');
while ($row = mysql_fetch_assoc($rso)) {
    if($partmes==''){
        $partmes = '<br />零件庫存不足通知:<br />';
    }
    $partmes .= $row['name'].' 現存量 '.$row['sumc'];
}

if($partmes!='' || $promes!=''){
    require_once("_mail.php");//載入mail function
    $mysql->table = 'member_data';
    $rs_super = $mysql->select("WHERE email<>'' and super_power = 1",'email,user_name');
    while ($row_super = mysql_fetch_assoc($rs_super)) {    
      sentmail($row_super['email'],$row_super['user_name'],'low alert','Dear '.$row_super['user_name'].' <br/>  '.$promes.$partmes);
    }
    //MAIL FUNCTION
}
?>