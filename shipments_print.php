<?
//載入共用的CSS 與 JQ
include("template_meta.php");
?>
<body>
<?
$shipments_id = _get('shipments_id');
if($shipments_id){
    $mysql->table = 'shipments_data';
    $row1 = mysql_fetch_assoc($mysql->select("LEFT JOIN BShipLink USING(shipments_id) LEFT JOIN mail_data USING(mail_id) WHERE shipments_id='$shipments_id'"));
    $info1 = unserialize($row1['info']);
    $mysql->table = 'Business_data';
    $row2 = mysql_fetch_assoc($mysql->select("LEFT JOIN member_data USING(member_id) WHERE BID='{$row1['BID']}'"));
    $info2 = unserialize($row2['Info']);
    $mysql->table = 'shipments_detail_data';
    $rs = $mysql->select("LEFT JOIN product_data USING(product_id) WHERE group_id='$shipments_id'");
} else {
    alert('連結錯誤!');
}

?> 
<table style="margin-left:auto;margin-right:auto;">
<tr ><td><img src="img/sys_img/test.png" style="display:block; margin:auto;" /></td></tr>
<tr ><td>3rd FL, No. 140, Lane 531, Chong Kang Rd.</td></tr>
<tr ><td>Hsin-Chuang City, Taipei, Taiwan, R.O.C.</td></tr>
<tr ><td>TEL: 886-2-2993-3383  FAX: 886-2-2992-0836 </td></tr>
<tr ><td>&nbsp;</td></tr>
<tr >
  <td style="font-family:'Times New Roman', Times, serif; text-align:center; font-size:24px;"><b><u>SHIPMENTS LIST</u></b></td></tr>
<tr ><td>&nbsp;</td></tr>
<tr ><td>&nbsp;</td></tr>
</table>	 	    
<table width="100%" class="table table-bordered">
  <tr>
    <td rowspan="4">Shipping Address:</br>
    <?=$info1['OutAddr']?></td>
    <td>Order Date:<?=date('Y/m/d H:i:s',$row2['ATime'])?></td>
  </tr>
  <tr>
    <td>Packing NO.:<?=$row1['number']?></td>
  </tr>
  <tr>
    <td>Invoice No.:<?=$row2['SN']?></td>
  </tr>
  <tr>
    <td>Contact:<?=$row2['user_name']?></td>
  </tr>
  <tr>
    <td>Customer:<?=$info2['IName']?></td>
    <td>Shipping Date:<?=$row1['create_time']?></td>
  </tr>
  <tr>
    <td rowspan="2">Customer Addr:<?=$info2['IAddr']?></td>
    <td>Carrier:<?=$row1['name']?></td>
  </tr>
  <tr>
    <td>Per:<?=$info2['Per']?></td>
  </tr>
  <tr>
    <td colspan="2">

    <table class="table table-bordered">
      <tr>
        <th>Item</th>
        <th>Quantity</th>
        <th>Description</th>
        <!--<th>單價</th>
        <th>小記</th>-->
      </tr>
      <? $tot = 0;
      while($row = mysql_fetch_assoc($rs)){
        if($row['count']>0){
          $scount = $row['count'] * $row['price'];
          $tot += $scount;
          ?>
      <tr>
        <th><?=$row['name']?></th>
        <th><?=$row['count']?></th>
        <th><?=$row['info']?></th>
        <? if (1==2){?>
        <th><?=$row['price']?></th>
        <th><?=$scount?></th>
        <? }?>
      </tr>
      <? }}?> 
    </table>
    </td>
  </tr>
  <tr>
    <td rowspan="3">Remark:<?=$info1['info']?></td>
    <td></td>
  </tr>
  <? if(1==2){?>
  <tr>
    <td rowspan="3">Remark:<?=$info1['info']?></td>
    <td>Net Value:<?=$tot?></td>
  </tr>
  <tr>
    <td>Delivery charge:<?=$row1['Invoice']?></td></td>
  </tr>
  <tr>
    <td>Invoice Total USD:<?=$tot+$row1['Invoice']?></td>
  </tr>
  <? }?>
</table>

<!--table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td><br />
          <div class="maincontent">
        	<div class="contentinner">
            	<h4 class="widgettitle">出貨檢視</h4>
                <div class="widgetcontent">
                <table class="table table-bordered">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>出貨編號</th>
                            <th>客戶名稱</th>
                            <th>出貨地點</th>
                            <th>出貨時間</th>
                            <th>備註</th>
                        </tr>
                    </thead>
                    <tbody>
                    <? while($row2 = mysql_fetch_assoc($rs2)){?>
                        <tr>
                            <td><?=$row2['number']; ?></td>
                            <td><?=$row2['client']; ?></td>
                            <td><?=$row2['location']; ?></td>
                            <td><?=$row2['create_time']; ?></td>
                            <td><?=$row2['info']; ?></td>
                        </tr>
                    <? }?>    
                    </tbody>
                </table>
                <div class="divider30"></div>
				<table class="table table-bordered">
                    <colgroup>
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                        <col class="con0">
                        <col class="con1">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>商品型號</th>
                            <th>數量</th>
                            <th>&nbsp;</th>
                        </tr>
                        <? while($row = mysql_fetch_assoc($rs)){?>
                        <tr>
                            <?
							$sql = 'select * from product_data';
							$sql .=' Where product_id ='.$row['product_id'];
							$rs3 = mysql_query($sql)or die(mysql_error()); //sql查詢
							?>
                            <? while($row3 = mysql_fetch_assoc($rs3)){?>
                            <th><?=$row3['number']; ?>(<?=$row3['name']; ?>)</th>
                            <? }?> 
                            <th><?=$row['count']; ?></th>
                            <th></th>
                        </tr>
                        <? }?> 
                    </thead>
                    <tbody id="test"> 
                        
                    </tbody>
                </table> 
                <p>&nbsp;</p> 
                <?
				$url="shipments_list.php";
				?>                
            </div><! --contentinner- ->
        </div><! --maincontent- ->      
    </div><!--contentinner- -></td>
    </tr>
  </table-->
<div class="clearfix"></div>
<script language=javascript>
  	print()
</script>      
</body>
</html>
